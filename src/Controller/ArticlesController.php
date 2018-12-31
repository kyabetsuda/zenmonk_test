<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Log\Log;
use Cake\Event\Event; // 追加

/**
 * Articles Controller
 *
 * @property \App\Model\Table\ArticlesTable $Articles
 *
 * @method \App\Model\Entity\Article[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ArticlesController extends AppController
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
			$article = $this->Articles->get($this->request->data['request'], [
			    'contain' => []
			]);
			Log::write('debug','before : ' . $article->content);
			$article->content = htmlspecialchars_decode($article->content,ENT_QUOTES|ENT_HTML5);
			Log::write('debug','after : ' . $article->content);
			$resultJ = json_encode($article);
			$this->response->type('json');
			$this->response->body($resultJ);
			return $this->response;
		}else{
			$this->cakeError('error404');
		}
	}

    public function index()
    {
        $this->paginate = [
            'contain' => ['Categories']
        ];
        $articles = $this->paginate($this->Articles);

        $this->set(compact('articles'));
    }

    /**
     * View method
     *
     * @param string|null $id Article id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $article = $this->Articles->get($id, [
            'contain' => ['Categories']
        ]);

        $this->set('article', $article);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $article = $this->Articles->newEntity();
        if ($this->request->is('post')) {
	        $article = $this->Articles->patchEntity($article, $this->request->getData());
	        $fileName =$this->request->data['image'];
			    $article->content = $this->MakeHtml->makeHtmlForArticles($article);
			    $article->thumbnail = $fileName['name'];
					$article->contName = 'articles';
			    if ($this->Articles->save($article)) {
            $this->Flash->success(__('The article has been saved.'));
      			move_uploaded_file($fileName['tmp_name'],'../webroot/img/articles/'. $fileName['name']);
            return $this->redirect(['action' => 'index']);
          }else{
						Log::write('error','記事の投稿に失敗しました');
					}
          $this->Flash->error(__('The article could not be saved. Please, try again.'));
        }
        $categories = $this->Articles->Categories->find('list', ['limit' => 200]);
        $this->set(compact('article', 'categories'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Article id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $article = $this->Articles->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $article = $this->Articles->patchEntity($article, $this->request->getData());
            if ($this->Articles->save($article)) {
                $this->Flash->success(__('The article has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The article could not be saved. Please, try again.'));
        }
        $categories = $this->Articles->Categories->find('list', ['limit' => 200]);
        $this->set(compact('article', 'categories'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Article id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $article = $this->Articles->get($id);
        if ($this->Articles->delete($article)) {
            $this->Flash->success(__('The article has been deleted.'));
        } else {
            $this->Flash->error(__('The article could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
