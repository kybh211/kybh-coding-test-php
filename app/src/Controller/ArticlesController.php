<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\View\JsonView;
use Cake\Http\Exception\UnauthorizedException;

/**
 * Articles Controller
 *
 * @property \App\Model\Table\ArticlesTable $Articles
 * @method \App\Model\Entity\Article[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ArticlesController extends AppController
{
    public function initialize(): void
    {
        parent::initialize();
    }

    public function viewClasses(): array
    {
        return [JsonView::class];
    }
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        // $this->Authorization->skipAuthorization();
        $this->paginate = [
            'contain' => [
                'Users' => function ($q) {
                    return $q
                        ->select(['Users.email']);
                }
            ],
        ];
        $articles = $this->paginate($this->Articles);

        $this->set(compact('articles'));
        $this->viewBuilder()->setOption('serialize', ['articles']);
    }

    /**
     * View method
     *
     * @param string|null $id Article id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        // $this->Authorization->skipAuthorization();
        $article = $this->Articles->get($id, [
            'contain' => [
                'Users' => function ($q) {
                    return $q
                        ->select(['Users.email']);
                },
            ],
        ]);

        $this->set(compact('article'));
        $this->viewBuilder()->setOption('serialize', ['article']);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $this->request->allowMethod(['post']);
        $article = $this->Articles->newEntity($this->request->getData());
        // Error
        // $this->Authorization->authorize($article);
        $article->user_id = $this->request->getAttribute('identity')->getIdentifier();

        if ($this->Articles->save($article)) {
            $message = 'Created.';
        } else {
            $message = 'Error.';
        }
        $this->set([
            'message' => $message,
            'article' => $article,
        ]);
        $this->viewBuilder()->setOption('serialize', ['article', 'message']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Article id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $this->request->allowMethod(['put']);
        $user = $this->Authentication->getIdentity();
        $article = $this->Articles->get($id);

        if ($user->id !== $article->user_id) {
            throw new UnauthorizedException(__('Unauthorized.'));
        }

        // Error
        // $this->Authorization->authorize($article);
        $article = $this->Articles->patchEntity($article, $this->request->getData(), [
            'accessibleFields' => ['user_id' => false]
        ]);
        if ($this->Articles->save($article)) {
            $message = 'Updated.';
        } else {
            $message = 'Error.';
        }
        $this->set([
            'message' => $message,
            'article' => $article,
        ]);
        $this->viewBuilder()->setOption('serialize', ['article', 'message']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Article id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['delete']);
        $user = $this->Authentication->getIdentity();

        $article = $this->Articles->get($id);
        if ($user->id !== $article->user_id) {
            throw new UnauthorizedException(__('Unauthorized.'));
        }

        // Not work
        // $this->Authorization->authorize($article);
        $message = 'Deleted.';
        if (!$this->Articles->delete($article)) {
            $message = 'Error.';
        }
        $this->set('message', $message);
        $this->viewBuilder()->setOption('serialize', ['message']);
    }

    /**
     * @param null $id
     */
    public function like($id = null) {
        $user = $this->Authentication->getIdentity();
        // get article
        $article = $this->Articles->get($id);
        // liked before?
        $liked = $this->Articles->Likes->find('all')->where([
            'article_id' => $article->id,
            'user_id' => $user->id,
        ])->first();

        if ($liked) {
            $message = 'You liked it before.';
            $this->set('message', $message);
            $this->viewBuilder()->setOption('serialize', ['message']);
            return;
        }

        // Like article
        $like = $this->Articles->Likes->newEntity([
            'article_id' => $article->id,
            'user_id' => $user->id,
        ]);
        $this->Articles->Likes->save($like);
        $message = 'Liked successfully.';
        $this->set('message', $message);
        $this->viewBuilder()->setOption('serialize', ['message']);
    }
    /**
     * @param \Cake\Event\EventInterface $event
     * @return \Cake\Http\Response|void|null
     */
    public function beforeFilter(\Cake\Event\EventInterface $event)
    {
        parent::beforeFilter($event);
        $this->Authentication->allowUnauthenticated(['index', 'view']);
    }
}
