<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Log\Log;
use Cake\Event\Event; // 追加
use Cake\ORM\TableRegistry;

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
			$this->Categories = TableRegistry::get('Categories');
			$this->ArticlesCategories = TableRegistry::get('ArticlesCategories');
	}

	public function isAuthorized($user)
	{
		return true;

	}

	public function beforeFilter(Event $event)
	{
		parent::beforeFilter($event);
		$this->Security->setConfig('unlockedActions', ['getContent','uploadArticle','plusCategory']);
		$this->Auth->allow(['index','getContent','uploadArticle','plusCategory']);
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
        $categories = $this->Categories->find('all');
        $this->set(compact('categories'));
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
				//記事
        $article = $this->Articles->get($id, [
            'contain' => ['Categories']
        ]);
				//カテゴリ
        $categories = $this->Categories->find('all');
        $this->set(compact('article', 'categories'));
    }


		public function uploadArticle(){
			$this->autoRender = FALSE;
			if($this->request->is('ajax')) {
				if($this->request->data['id'] != null){
					$article = $this->Articles->find()->where(['id' => $this->request->data['id']])->first();
					//articleがnullの場合は新規追加
					if($article == null){
						$article = $this->Articles->newEntity();
					}
				}else{
					//idがそもそも設定されていない場合は新規追加
					$article = $this->Articles->newEntity();
					Log::write('debug','new Entity was created, id : ' . $article->id);
				}

				//各種データ登録
				$article->title = $this->request->data['title'];
				$article->thumbnail = $this->request->data['thumbnail'];
				$article->content = $this->MakeHtml->makeHtmlForArticles($this->request->data['content']);
				$article->contName = "articles";

				//更新
				if ($this->Articles->save($article)) {
					$this->Flash->success(__('The article has been saved.'));
				}else{
					$this->cakeError('error404');
				}

				//一旦カテゴリーを全部削除する
				$ArticlesCategoriesForDelete = $this->ArticlesCategories->find()->where(['article_id' => $article->id]);
				foreach($ArticlesCategoriesForDelete as $category){
					Log::write('debug','category id is : ' . $category);
					if ($this->ArticlesCategories->delete($category)) {
	            $this->Flash->success(__('The article has been deleted.'));
	        } else {
	            $this->cakeError('error404');
	        }
				}

				//カテゴリー登録
				foreach($this->request->data['categories'] as $category){
					$ArticleCategory = $this->ArticlesCategories->newEntity();
					$ArticleCategory->article_id = $article->id;
					$ArticleCategory->category_id = $category;
					if ($this->ArticlesCategories->save($ArticleCategory)) {
					   $this->Flash->success(__('The article has been deleted.'));
					} else {
					   $this->cakeError('error404');
					}
				}


			}else{
				$this->cakeError('error404');
			}
		}

		public function plusCategory(){
			$this->autoRender = FALSE;
			if($this->request->is('ajax')) {
				$category = $this->Categories->newEntity();
				$category->name = $this->request->data['category'];

				//新規カテゴリー登録
				if ($this->Categories->save($category)) {
						$this->Flash->success(__('The article has been saved.'));
						$categories = $this->Categories->find('all');

						//新しいカテゴリーリストを返却
						$resultJ = json_encode($categories);
		        $this->response->type('json');
		        $this->response->body($resultJ);
		        return $this->response;

				}else{
					$this->cakeError('error404');
				}
			}else{
				$this->cakeError('error404');
			}
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
