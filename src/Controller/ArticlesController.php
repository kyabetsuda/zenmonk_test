<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Log\Log;
use Cake\Event\Event; // 追加
use Cake\ORM\TableRegistry;
use Cake\Core\Configure;
use Cake\Datasource\ConnectionManager;

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
			$this->Mails = TableRegistry::get('Mails');
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
		$this->Security->setConfig('unlockedActions', [
			'index',
			'getContent',
			'getContentByCategory',
			'uploadArticle',
			'getCategories',
			'plusCategory',
			'delete',
			'sendMail'
		]);

		$this->Auth->allow(['index',
			'post',
			'getContent',
			'getContentByCategory',
			'uploadArticle',
			'getCategories',
			'plusCategory',
			'delete',
			'sendMail'
		]);
	}

	/**
	* 記事の一覧
	*
	* @return
	*/
	public function index()
	{
		$this->autoRender = FALSE;
		if($this->request->is('ajax')) {
			$conn = ConnectionManager::get('default');
			$stmt = $conn->prepare(
	    	'select * from articles where draft = :draft order by upd_ymd desc'
			);
			$stmt->bindValue(':draft', '0');
			$stmt->execute();
			$article = $stmt->fetchAll('assoc');
			$resultJ = json_encode($article);
			$this->response->type('json');
			$this->response->body($resultJ);
			return $this->response;
		}else{
			$this->cakeError('error404');
		}

	    // $this->paginate = [
			// 		'conditions'=>['draft'=>'0'],
	    //     'contain' => ['Categories']
	    // ];
	    // $articles = $this->paginate($this->Articles);
	    // $this->set(compact('articles'));
	}

	/**
	* 記事の取得
	*
	* @return
	*/
	public function getContent(){
		$this->autoRender = FALSE;
		if($this->request->is('ajax')) {
			//$articles = $this->Articles->find()->where(['title like' => '%' . $this->request->data['word'] . '%', 'draft' => '0']);
			$conn = ConnectionManager::get('default');
			$stmt = $conn->prepare(
				'select * from articles where draft = :draft and title like :title'
			);
			$stmt->bindValue(':draft', '0');
			$stmt->bindValue(':title', '%' . $this->request->data['word'] . '%');
			$stmt->execute();
			$articles = $stmt->fetchAll('assoc');
			$resultJ = json_encode($articles);
			$this->response->type('json');
			$this->response->body($resultJ);
			return $this->response;
		}else{
			$this->cakeError('error404');
		}
	}

	public function getContentByCategory(){
		$this->autoRender = FALSE;
		$conn = ConnectionManager::get('default');
		$stmt = $conn->prepare(
			'select'
			. ' t1.id'
			. ' ,t1.thumbnail'
			. ' ,t1.title'
			. ' ,t1.upd_ymd'
			. ' from'
			. ' articles t1'
			. ',articles_categories t2'
			. ',categories t3'
			. ' where t1.draft = :draft'
			. ' and t1.id = t2.article_id'
			. ' and t2.category_id = t3.id'
			. ' and t3.name = :name'
		);
		$stmt->bindValue(':draft', '0');
		$stmt->bindValue(':name', $this->request->data['word']);
		$stmt->execute();
		$articles = $stmt->fetchAll('assoc');
		Log::write('debug',$articles);
		$resultJ = json_encode($articles);
		$this->response->type('json');
		$this->response->body($resultJ);
		return $this->response;
	}

  /**
   * View method
   *
   * @param
   * @return
   * @throws
   */
  public function post($id = null)
  {
      $article = $this->Articles->get($id, [
          'contain' => ['Categories']
      ]);
			$article->content = htmlspecialchars_decode($article->content,ENT_QUOTES|ENT_HTML5);
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
		$conn = ConnectionManager::get('default');
		$stmt = $conn->prepare(
			'select t1.id, t1.title, t1.thumbnail, t1.upd_ymd from articles t1 order by t1.upd_ymd desc'
		);
		$stmt->execute();
		$articles = $stmt->fetchAll('assoc');
		// $this->paginate = [
		// 		'contain' => ['Categories']
		// ];
		// $articles = $this->paginate($this->Articles);
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
				//articleがeditの場合はコンテンツをそのままセットする
				//ここは保守性が悪い気がする。いずれ訂正したい
				$article->content = h($this->request->data['content']);
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
				//リクエストのdraftに何か設定されている場合のみ設定(設定されていない場合、かつeditの場合に元の値を保持するため)
				//javascript側で設定されていない場合は初期値-1をそのまま渡すようにしている
				$article->draft = $this->request->data['draft'];
			}
			Log::write('debug','before save');
			//更新
			if ($this->Articles->save($article)) {
				$this->Flash->success(__('The article has been saved.'));
			}else{
				$this->cakeError('error404');
			}
			Log::write('debug','after save');
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
   * カテゴリーの取得(ajax)
   *
   * @param
   * @return
   * @throws
   */
	public function getCategories(){
		$this->autoRender = FALSE;
		if($this->request->is('ajax')) {
			$categories = $this->Categories->find('all');
			$resultJ = json_encode($categories);
			$this->response->type('json');
			$this->response->body($resultJ);
			return $this->response;
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

	/**
   * Send a mail method(ajax)
   *
   * @param
   * @return
   * @throws
   */
	public function sendMail(){
		$this->autoRender = FALSE;

		mb_language("Japanese");
		mb_internal_encoding("UTF-8");
		$to = "junn135246@icloud.com";
		$title = $this->request->data['title'];
		$content = $this->request->data['content'];
		$name = 'From: ' . $this->request->data['name'];

		$mail = $this->Mails->newEntity();
		$mail->name = $name;
		$mail->title = $title;
		$mail->content = $content;
		$mail->remote_address = $_SERVER["REMOTE_ADDR"];
		if (!$this->Mails->save($mail)) {
			$this->response->type('text');
			$this->response->body('メール送信に失敗しました'
				. "\n"
				. '●予想される原因'
				. "\n"
				. 'メールは一日5回までしか送信できません'
			);
			$this->response->statusCode(404);
			return $this->response;
		}

		if(mb_send_mail($to, $title, $content, $name)){
			Log::write('debug','sending mail success');
		} else {
			Log::write('debug','sending mail failed');
		}
	}
}
