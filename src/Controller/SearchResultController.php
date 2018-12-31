<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;
use Cake\Event\Event; // 追加
/**
 * SearchResult Controller
 *
 *
 * @method \App\Model\Entity\SearchResult[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class SearchResultController extends AppController
{

	public function initialize()
	{
		parent::initialize();
		$this->Pictures = TableRegistry::get('Pictures');
		$this->Articles = TableRegistry::get('Articles');
		$this->Videos = TableRegistry::get('Videos');

	}

	public function isAuthorized($user)
	{
		return true;

	}

	public function beforeFilter(Event $event)
	{
		parent::beforeFilter($event);
		$this->Auth->allow(['index']);
	}

	/**
	* Index method
	*
	* @return \Cake\Http\Response|void
	*/
	public function index()
	{
		if ($this->request->is('post')) {
		$title = $this->request->getData('word');
		$pictures = $this->Pictures->find('all')
			->where(['title like' =>"%" . $title . "%"]);
		$articles = $this->Articles->find('all')
			->where(['title like' =>"%" . $title . "%"]);
		$videos = $this->Videos->find('all')
			->where(['title like' =>"%" . $title . "%"]);

		$results = array_merge($pictures->toArray(), $articles->toArray(), $videos->toArray());
		$this->set(compact('results'));



		}else{
			return $this->redirect('/error');
		}

	}

//    /**
//     * View method
//     *
//     * @param string|null $id Search Result id.
//     * @return \Cake\Http\Response|void
//     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
//     */
//    public function view($id = null)
//    {
//        $searchResult = $this->SearchResult->get($id, [
//            'contain' => []
//        ]);
//
//        $this->set('searchResult', $searchResult);
//    }
//
//    /**
//     * Add method
//     *
//     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
//     */
//    public function add()
//    {
//        $searchResult = $this->SearchResult->newEntity();
//        if ($this->request->is('post')) {
//            $searchResult = $this->SearchResult->patchEntity($searchResult, $this->request->getData());
//            if ($this->SearchResult->save($searchResult)) {
//                $this->Flash->success(__('The search result has been saved.'));
//
//                return $this->redirect(['action' => 'index']);
//            }
//            $this->Flash->error(__('The search result could not be saved. Please, try again.'));
//        }
//        $this->set(compact('searchResult'));
//    }
//
//    /**
//     * Edit method
//     *
//     * @param string|null $id Search Result id.
//     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
//     * @throws \Cake\Network\Exception\NotFoundException When record not found.
//     */
//    public function edit($id = null)
//    {
//        $searchResult = $this->SearchResult->get($id, [
//            'contain' => []
//        ]);
//        if ($this->request->is(['patch', 'post', 'put'])) {
//            $searchResult = $this->SearchResult->patchEntity($searchResult, $this->request->getData());
//            if ($this->SearchResult->save($searchResult)) {
//                $this->Flash->success(__('The search result has been saved.'));
//
//                return $this->redirect(['action' => 'index']);
//            }
//            $this->Flash->error(__('The search result could not be saved. Please, try again.'));
//        }
//        $this->set(compact('searchResult'));
//    }
//
//    /**
//     * Delete method
//     *
//     * @param string|null $id Search Result id.
//     * @return \Cake\Http\Response|null Redirects to index.
//     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
//     */
//    public function delete($id = null)
//    {
//        $this->request->allowMethod(['post', 'delete']);
//        $searchResult = $this->SearchResult->get($id);
//        if ($this->SearchResult->delete($searchResult)) {
//            $this->Flash->success(__('The search result has been deleted.'));
//        } else {
//            $this->Flash->error(__('The search result could not be deleted. Please, try again.'));
//        }
//
//        return $this->redirect(['action' => 'index']);
//    }
}
