<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Http\Client;
use Cake\Http\Response;


class MaterialController extends AppController {
	
	private const YOUTUBE_API_KEY = 'AIzaSyCcYWv3h3QRoX7-obSfhm3Xo-V4w7smlCc';
	
	private const YOUTUBE_API_REQUEST = 'https://www.googleapis.com/youtube/v3/search';
	
	private const YOUTUBE_MAX_RESULTS = 25;
	
	public function index() : Response {
		return $this->render();
	}
	
	public function biblioteca() : Response {
		$subject = $this->Subjects
						->get($this->subjectID, ['contain' => 'Books']);
		$this->set('subject', $subject);
		return $this->render();
	}
	
	public function videoteca() : Response {
		$channelID = $this->Options->get('youtube')->get('YouTubeChannelID');

		$http = new Client();
		$response = $http->get(self::YOUTUBE_API_REQUEST, [
					'channelId' => $channelID,
					'type' => 'video',
					'order' => 'date',
					'part' => 'snippet',
					'maxResults' => self::YOUTUBE_MAX_RESULTS,
					'key' => self::YOUTUBE_API_KEY,
			]
		);
		$response = json_decode($response->getStringBody());
		$this->set('videos', $response->items);
		return $this->render();
	}
}