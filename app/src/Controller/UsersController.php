<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Utility\Security;
use Cake\View\JsonView;

/**
 * Users Controller
 *
 * @property \App\Model\Table\UsersTable $Users
 * @method \App\Model\Entity\User[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class UsersController extends AppController
{
    public function viewClasses(): array
    {
        return [JsonView::class];
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        // $this->Authorization->skipAuthorization();
        $this->request->allowMethod(['post']);
        $user = $this->Users->newEntity($this->request->getData());
        if ($this->Users->save($user)) {
            $message = 'Create user successfully!';
        } else {
            $message = 'Error when create user.';
        }
        $this->set([
            'message' => $message,
            'user' => $user,
        ]);
        $this->viewBuilder()->setOption('serialize', ['user', 'message']);
    }

    /**
     *
     */
    public function login()
    {
        // $this->Authorization->skipAuthorization();
        $result = $this->Authentication->getResult();
        if ($result->isValid()) {
            $userIdentity = $this->Authentication->getIdentity();

            $user = $userIdentity->getOriginalData();
            $user->token = $this->generateToken();
            $user = $this->Users->save($user);
            $user = $this->Users->get($user->id);

            $this->set(compact('user'));
            $this->viewBuilder()->setOption('serialize', ['user']);
        }
    }

    /**
     * @return \Cake\Http\Response|null
     */
    public function logout()
    {
        // $this->Authorization->skipAuthorization();
        $result = $this->Authentication->getResult();
        if ($result->isValid()) {
            $userIdentity = $this->Authentication->getIdentity();

            $user = $userIdentity->getOriginalData();
            $user->token = null;
            $user = $this->Users->save($user);

            $message = 'Logout';
            $this->set(compact('message'));
            $this->viewBuilder()->setOption('serialize', ['message']);
        }
    }

    /**
     * @param int $length
     * @return array|string|string[]|null
     */
    private function generateToken(int $length = 36)
    {
        $random = base64_encode(Security::randomBytes($length));
        $cleaned = preg_replace('/[^A-Za-z0-9]/', '', $random);
        return $cleaned;
    }

    /**
     * @param \Cake\Event\EventInterface $event
     * @return \Cake\Http\Response|void|null
     */
    public function beforeFilter(\Cake\Event\EventInterface $event)
    {
        parent::beforeFilter($event);
        $this->Authentication->allowUnauthenticated(['login', 'index', 'view']);
    }
}
