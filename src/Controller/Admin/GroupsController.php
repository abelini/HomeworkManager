<?php
declare(strict_types=1);

namespace App\Controller\Admin;

use App\Controller\AppController;
use Cake\Http\Response;
use Cake\I18n\FrozenTime;


class GroupsController extends AppController {

	public function lista() : Response {
		$id = $this->request->getQuery('grupo');
		$title = parent::$title;
		$fecha = FrozenTime::now();
		$sum = $counter = 0;
		$npValue = $this->Options->get('scoreConfig')->getNPScoreValue();
		$nvValue = $this->Options->get('scoreConfig')->getNVScoreValue();
		$grupo = $this->Groups->get($id);
		$tareas = $this->fetchTable('Papers')
						->find()
						->select(['id', 'name'])
						->where(['group_id' => $id])
						->all();
										
		$alumnos = $this->Groups->Users
							->find()
							->select(['id', 'nombres', 'apellidos', 'group_id', 'pr', 'created'])
							->where([
								'group_id' => $id,
								'admin' => 0,
							])
							->order('apellidos ASC')
							->contain([
								/*'Status' => ['fields' => ['class']],*/
								'Homeworks' => [
									'fields' => ['id', 'paper_id', 'user_id', 'score']
								]
							])
							->all();
		$getCiclo = function(FrozenTime $date) : string {
				if($date->month >= 1 && $date->month <= 6){
					return ($date->year - 1) .'/'. $date->year . ' - 2 (Ene-Jun)';
				} else {
					return $date->year .'/'. ($date->year + 1) . ' - 1 (Ago-Dic)';
				}
		};
		$this->set(compact('npValue', 'nvValue', 'tareas', 'alumnos', 'grupo', 'hwCounter', 'title', 'fecha', 'sum', 'counter', 'getCiclo'));
		
		$this->viewBuilder()->setClassName('CakePdf.Pdf');
		$this->viewBuilder()->setHelpers(['Url', 'Html']);
		$this->viewBuilder()->setLayout(null);
		$this->viewBuilder()->setOption(
			'pdfConfig', [
				//'engine' => 'CakePdf.WkHtmlToPdf',
				//'binary' => 'wkhtmltopdf',
				'download' => true,
				'orientation' => 'landscape',
				'toc' => false,
				'margin' => [
					'bottom' => 0,
					'left' => 5,
					'right' => 5,
					'top' => 10
				],
				'filename' => 'lista-'.time().'.pdf',
			]
		);
		
		return $this->render();
	}

	public function kardex($id) : Response {
		$hwCounter = 1;
		$npValue = $this->Options->get('scoreConfig')->getNPScoreValue();
		$nvValue = $this->Options->get('scoreConfig')->getNVScoreValue();
		$tareas = $this->fetchTable('Papers')->find()
										->select(['id', 'name'])
										->where([
											'group_id' => $id,
										])
										->all();
		$alumnos = $this->Groups->Users->find()
							->select(['id', 'nombres', 'apellidos', 'group_id', 'pr'])
							->where([
								'group_id' => $id,
								'admin' => 0,
							])
							->order('apellidos ASC')
							->contain([
								/*'Status' => ['fields' => ['class']],*/
								'Homeworks' => [
									'fields' => ['id', 'paper_id', 'user_id', 'score']
								]
							])
							->all();
		$grupo = $this->Groups->get($id);
		$score = function($r) : string {
			return match($r) {
				0 => '<span class="w3-text-red" title="No se ha calificado la tarea"><i class="fa-solid fa-question"></i></span>',
				'NV' => '<span title="No valorable: 5 (Cinco)">NV</span>',
				'NP' => '<span title="No presentó: 0 (Cero)">NP</span>',
				default => (string) $r,
			};
		};
		$this->set(compact('npValue', 'nvValue', 'tareas', 'alumnos', 'grupo', 'hwCounter', 'score'));
		return $this->render();
    }

    public function view($id = null) : Reponse {
		$group = $this->Groups->get($id);
		$this->set(compact('group'));
		return $this->render();
	}

	public function edit($id = null) : Response {
		$group = $this->Groups->get($id);
		if ($this->request->is(['patch', 'post', 'put'])) {
			$group = $this->Groups->patchEntity($group, $this->request->getData());
			if ($this->Groups->save($group)) {
				$this->Flash->success(__('The group has been saved.'));
				return $this->redirect(['action' => 'index']);
			}
			$this->Flash->error(__('The group could not be saved. Please, try again.'));
		}
		$this->set(compact('group'));
		return $this->render();
	}
}
