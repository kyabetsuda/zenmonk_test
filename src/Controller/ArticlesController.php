<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Log\Log;
use Cake\Event\Event; // 追加
use Cake\ORM\TableRegistry;
use Cake\Core\Configure;

/**
 * Articles Controller
 *
 * @property \App\Model\Table\ArticlesTable $Articles
 *
 * @method \App\Model\Entity\Article[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ArticlesController extends AppController
{

	/**
	* initialize
	*
	* @return
	*/
	public function initialize()
	{
	    parent::initialize();
	    $this->loadComponent('MakeHtml');
			$this->Categories = TableRegistry::get('Categories');
			$this->ArticlesCategories = TableRegistry::get('ArticlesCategories');
	}


	/**
	* izAuthorized
	*
	* @return
	*/
	public function isAuthorized($user)
	{
		return true;

	}

	/**
	* beforeFilter
	*
	* @return
	*/
	public function beforeFilter(Event $event)
	{
		parent::beforeFilter($event);
		$this->Security->setConfig('unlockedActions', ['getContent','uploadArticle','plusCategory','delete']);
		$this->Auth->allow(['index','getContent','uploadArticle','plusCategory','delete']);
	}

	/**
	* 記事の取得
	*
	* @return
	*/
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

	/**
	* 記事の一覧
	*
	* @return
	*/
	public function index()
	{
	    $this->paginate = [
					'conditions'=>['draft'=>'0'],
	        'contain' => ['Categories']
	    ];
	    $articles = $this->paginate($this->Articles);
	    $this->set(compact('articles'));
	}

  /**
   * View method
   *
   * @param
   * @return
   * @throws
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
   * @return
   */
  public function add()
  {
      $categories = $this->Categories->find('all');
      $this->set(compact('categories'));
  }


	/**
   * 編集および削除記事リストの表示
   *
   * @return
   */
	public function editOrDeleteList(){
		$secretUrl = Configure::read("secretUrl");
		$this->paginate = [
				'contain' => ['Categories']
		];
		$articles = $this->paginate($this->Articles);
		$this->set(compact('articles','secretUrl'));
	}


	/**
   * Edit method
   *
   * @param
   * @return
   * @throws
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


	/**
   * 記事のアップロード(ajax)
   *
   * @param
   * @return
   * @throws
   */
	public function uploadArticle(){
		$this->autoRender = FALSE;
		if($this->request->is('ajax')) {
			if($this->request->data['id'] != null){
				$article = $this->Articles->find()->where(['id' => $this->request->data['id']])->first();
				$article->content = $this->request->data['content'];
				//articleがnullの場合は新規追加
				if($article == null){
					$article = $this->Articles->newEntity();
					$article->content = $this->MakeHtml->makeHtmlForArticles($this->request->data['content']);
				}
			}else{
				//idがそもそも設定されていない場合は新規追加
				$article = $this->Articles->newEntity();
				$article->content = $this->MakeHtml->makeHtmlForArticles($this->request->data['content']);
				Log::write('debug','new Entity was created, id : ' . $article->id);
			}

			//各種データ登録
			$article->title = $this->request->data['title'];
			$article->thumbnail = $this->request->data['thumbnail'];
			$article->contName = "articles";
			if($this->request->data['draft']  > -1){
				$article->draft = $this->request->data['draft'];
			}

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


	/**
   * カテゴリーの登録(ajax)
   *
   * @param
   * @return
   * @throws
   */
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
   * Delete method(ajax)
   *
   * @param
   * @return
   * @throws
   */
  public function delete()
  {
			$this->autoRender = FALSE;
      $this->request->allowMethod(['ajax']);
      $article = $this->Articles->get($this->request->data['id']);
      if ($this->Articles->delete($article)) {
          $this->Flash->success(__('The article has been deleted.'));
      } else {
          $this->Flash->error(__('The article could not be deleted. Please, try again.'));
      }
  }
}
