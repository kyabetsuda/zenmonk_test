<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Log\Log;
use Cake\Event\Event; // 追加
/**
 * Processings Controller
 *
 * @property \App\Model\Table\ProcessingsTable $Processings
 *
 * @method \App\Model\Entity\Processing[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ProcessingsController extends AppController
{

	public function initialize()
	{
	    parent::initialize();
	    $this->loadComponent('MakeHtml');
	}

    	public function isAuthorized($user)
	{
		return true;

	}
	
	public function beforeFilter(Event $event)
	{
		parent::beforeFilter($event);
		$this->Security->setConfig('unlockedActions', ['getContent']);
		$this->Auth->allow(['index','getContent']);
	}
	
	public function getContent(){
		$this->autoRender = FALSE;
		if($this->request->is('ajax')) {
			$processing = $this->Processings->get($this->request->data['request'], [
			    'contain' => []
			]);
			$processing->content = htmlspecialchars_decode($processing->content,ENT_QUOTES|ENT_HTML5);
			Log::write('debug',$processing->content);
			$resultJ = json_encode($processing);
			$this->response->type('json');
			$this->response->body($resultJ);
			return $this->response;
		}else{
			$this->cakeError('error404');
		}
	}

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $processings = $this->paginate($this->Processings);

        $this->set(compact('processings'));
    }


    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $processing = $this->Processings->newEntity();
        if ($this->request->is('post')) {
            $fileName = $this->request->data['image'];
	    $jsfile = $this->request->data['js'];
	    $processing = $this->Processings->patchEntity($processing, $this->request->getData());
	    $processing->content = $this->MakeHtml->makeHtmlForProcessings($processing);
	    $processing->extension = pathinfo($fileName['name'], PATHINFO_EXTENSION);
	    if ($this->Processings->save($processing)) {
                $this->Flash->success(__('The processing has been saved.'));
	        move_uploaded_file($fileName['tmp_name'],'../webroot/img/processings/'. $processing->title . '.' . $processing->extension);    
	        move_uploaded_file($jsfile['tmp_name'],'../webroot/js/processings/'. $processing->title . '.js');    
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The processing could not be saved. Please, try again.'));
        }
        $this->set(compact('processing'));
    }


    /**
     * Delete method
     *
     * @param string|null $id Processing id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $processing = $this->Processings->get($id);
        if ($this->Processings->delete($processing)) {
            $this->Flash->success(__('The processing has been deleted.'));
        } else {
            $this->Flash->error(__('The processing could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
    
//    /**
//     * View method
//     *
//     * @param string|null $id Processing id.
//     * @return \Cake\Http\Response|void
//     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
//     */
//    public function view($id = null)
//    {
//        $processing = $this->Processings->get($id, [
//            'contain' => []
//        ]);
//
//        $this->set('processing', $processing);
//    }
    
    /**
     * Edit method
     *
     * @param string|null $id Processing id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    //public function edit($id = null)
    //{
    //    $processing = $this->Processings->get($id, [
    //        'contain' => []
    //    ]);
    //    if ($this->request->is(['patch', 'post', 'put'])) {
    //        $processing = $this->Processings->patchEntity($processing, $this->request->getData());
    //        if ($this->Processings->save($processing)) {
    //            $this->Flash->success(__('The processing has been saved.'));

    //            return $this->redirect(['action' => 'index']);
    //        }
    //        $this->Flash->error(__('The processing could not be saved. Please, try again.'));
    //    }
    //    $this->set(compact('processing'));
    //}
}
