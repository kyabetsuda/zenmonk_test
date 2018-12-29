<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event; // 追加
use Cake\Log\Log;

/**
 * Pictures Controller
 *
 * @property \App\Model\Table\PicturesTable $Pictures
 *
 * @method \App\Model\Entity\Picture[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class PicturesController extends AppController
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
			$picture = $this->Pictures->get($this->request->data['request'], [
			    'contain' => []
			]);
			$picture->content = htmlspecialchars_decode($picture->content,ENT_QUOTES|ENT_HTML5);
			$resultJ = json_encode($picture);
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
		$pictures = $this->paginate($this->Pictures);
		$this->set(compact('pictures'));
	}


    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $picture = $this->Pictures->newEntity();
        if ($this->request->is('post')) {
          $fileName =$this->request->data['image'];
			    $picture->title = $this->request->data['title'];
					$picture->thumbnail = $fileName['name'];
			    $picture->content = $this->MakeHtml->makeHtmlForPictures($picture);
					$picture->contName = 'Pictures';
	    	if ($this->Pictures->save($picture)) {
					$this->Flash->success(__('The picture has been saved.'));
	        move_uploaded_file($fileName['tmp_name'],'../webroot/img/pictures/' . $fileName['name']);
					return $this->redirect('/pictures');
        }
            $this->Flash->error(__('The picture could not be saved. Please, try again.'));
        }
    }


    /**
     * Delete method
     *
     * @param string|null $id Picture id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $picture = $this->Pictures->get($id);
        if ($this->Pictures->delete($picture)) {
            $this->Flash->success(__('The picture has been deleted.'));
        } else {
            $this->Flash->error(__('The picture could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    /**
     * View method
     *
     * @param string|null $id Picture id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
//    public function view($id = null)
//    {
//        $picture = $this->Pictures->get($id, [
//            'contain' => []
//        ]);
//
//        $this->set('picture', $picture);
//    }
    /**
     * Edit method
     *
     * @param string|null $id Picture id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
 //   public function edit($id = null)
 //   {
 //       $picture = $this->Pictures->get($id, [
 //           'contain' => []
 //       ]);
 //       if ($this->request->is(['patch', 'post', 'put'])) {
 //           $picture = $this->Pictures->patchEntity($picture, $this->request->getData());
 //           if ($this->Pictures->save($picture)) {
 //               $this->Flash->success(__('The picture has been saved.'));

 //               return $this->redirect(['action' => 'index']);
 //           }
 //           $this->Flash->error(__('The picture could not be saved. Please, try again.'));
 //       }
 //       $this->set(compact('picture'));
 //   }


}
