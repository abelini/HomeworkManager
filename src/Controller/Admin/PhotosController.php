<?php
declare(strict_types=1);

namespace App\Controller\Admin;

use App\Controller\AppController;
use App\Model\Entity\DisplayedPaper;
use Cake\Core\Configure;
use Cake\Http\Response;
use Cake\View\Exception\MissingTemplateException;
use Cake\Database\Expression\QueryExpression;
use Cake\ORM\Query;
use Cake\Collection\Collection;
use Cake\ORM\Table;

use Cake\Filesystem\Folder;
use Cake\Filesystem\File;

class PhotosController extends AppController {
	
	private const IMAGES_PATH = '/home/historia/public_html/webroot/img/docs/';
	
	public function orphaned() : Response {
		$count = 0;
		$orphanedPics = array(); //new Collection([]);
		$moreThanOneParent = array();
		$directory = new Folder(self::IMAGES_PATH);
		$files = $directory->find('.*\.*', true);
		
		foreach($files as $file) {
			$results = $this->Homeworks
							->find()
							->where(function(QueryExpression $exp, Query $q) use ($file) {
								return $exp->like('texto', "%{$file}%");
							})
							->count();
			if($results == 0) {
				$picture = new File(self::IMAGES_PATH . $file);
				$picture->delete();
				$picture->close();
				$count++;
			} else if($results > 1) {
				array_push($moreThanOneParent, $file);
			}
		}
		
		$this->set(compact('count', 'orphanedPics', 'moreThanOneParent'));
		
		return $this->render();
	}
}