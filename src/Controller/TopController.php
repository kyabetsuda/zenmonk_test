<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event; // 追加
/**
 * Top Controller
 *
 *
 * @method \App\Model\Entity\Top[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class TopController extends AppController
{

	public function isAuthorized($user)
	{
		return true;

	}

	public function beforeFilter(Event $event)
	{
		parent::beforeFilter($event);
		$this->Auth->allow([
			'index'
		]);
	}

	/**
	* Index method
	*
	* @return \Cake\Http\Response|void
	*/
	public function index()
	{

	}

//    /**
//     * View method
//     *
//     * @param string|null $id Top id.
//     * @return \Cake\Http\Response|void
//     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
//     */
//    public function view($id = null)
//    {
//        $top = $this->Top->get($id, [
//            'contain' => []
//        ]);
//
//        $this->set('top', $top);
//    }
//
//    /**
//     * Add method
//     *
//     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
//     */
//    public function add()
//    {
//        $top = $this->Top->newEntity();
//        if ($this->request->is('post')) {
//            $top = $this->Top->patchEntity($top, $this->request->getData());
//            if ($this->Top->save($top)) {
//                $this->Flash->success(__('The top has been saved.'));
//
//                return $this->redirect(['action' => 'index']);
//            }
//            $this->Flash->error(__('The top could not be saved. Please, try again.'));
//        }
//        $this->set(compact('top'));
//    }
//
//    /**
//     * Edit method
//     *
//     * @param string|null $id Top id.
//     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
//     * @throws \Cake\Network\Exception\NotFoundException When record not found.
//     */
//    public function edit($id = null)
//    {
//        $top = $this->Top->get($id, [
//            'contain' => []
//        ]);
//        if ($this->request->is(['patch', 'post', 'put'])) {
//            $top = $this->Top->patchEntity($top, $this->request->getData());
//            if ($this->Top->save($top)) {
//                $this->Flash->success(__('The top has been saved.'));
//
//                return $this->redirect(['action' => 'index']);
//            }
//            $this->Flash->error(__('The top could not be saved. Please, try again.'));
//        }
//        $this->set(compact('top'));
//    }
//
//    /**
//     * Delete method
//     *
//     * @param string|null $id Top id.
//     * @return \Cake\Http\Response|null Redirects to index.
//     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
//     */
//    public function delete($id = null)
//    {
//        $this->request->allowMethod(['post', 'delete']);
//        $top = $this->Top->get($id);
//        if ($this->Top->delete($top)) {
//            $this->Flash->success(__('The top has been deleted.'));
//        } else {
//            $this->Flash->error(__('The top could not be deleted. Please, try again.'));
//        }
//
//        return $this->redirect(['action' => 'index']);
//    }
}
