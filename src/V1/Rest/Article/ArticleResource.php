<?php
namespace ApigilityBlog\V1\Rest\Article;

use ApigilityCatworkFoundation\Base\ApigilityResource;
use Zend\ServiceManager\ServiceManager;
use ZF\ApiProblem\ApiProblem;

class ArticleResource extends ApigilityResource
{
    /**
     * @var \ApigilityUser\Service\UserService
     */
    protected $userService;

    /**
     * @var \ApigilityUser\Service\IdentityService
     */
    protected $identityService;

    /**
     * @var \ApigilityBlog\Service\ArticleService
     */
    protected $articleService;

    public function __construct(ServiceManager $services)
    {
        parent::__construct($services);
        $this->articleService = $services->get('ApigilityBlog\Service\ArticleService');
        $this->userService = $services->get('ApigilityUser\Service\UserService');
        $this->identityService = $services->get('ApigilityUser\Service\IdentityService');
    }

    /**
     * Create a resource
     *
     * @param  mixed $data
     * @return ApiProblem|mixed
     */
    public function create($data)
    {
        try {
            $user = $this->userService->getAuthUser();
            return new ArticleEntity($this->articleService->createArticle($data, $user), $this->serviceManager);
        } catch (\Exception $exception) {
            return new ApiProblem($exception->getCode(), $exception->getMessage());
        }
    }

    /**
     * 更新一个
     *
     * @param mixed $id
     * @param mixed $data
     * @return ArticleEntity|ApiProblem
     */
    public function patch($id, $data)
    {
        try {
            $auth_user = $this->userService->getAuthUser();
            $identity = $this->identityService->getIdentity($auth_user->getId());
            return new ArticleEntity($this->articleService->updateArticle($id, $data, $identity), $this->serviceManager);
        } catch (\Exception $exception) {
            return new ApiProblem($exception->getCode(), $exception->getMessage());
        }
    }

    /**
     * Delete a resource
     *
     * @param  mixed $id
     * @return ApiProblem|mixed
     */
    public function delete($id)
    {
        try {
            $auth_user = $this->userService->getAuthUser();
            $identity = $this->identityService->getIdentity($auth_user->getId());
            return $this->articleService->deleteArticle($id, $identity);
        } catch (\Exception $exception) {
            return new ApiProblem($exception->getCode(), $exception->getMessage());
        }
    }

    /**
     * Fetch a resource
     *
     * @param  mixed $id
     * @return ApiProblem|mixed
     */
    public function fetch($id)
    {
        try {
            return new ArticleEntity($this->articleService->getArticle($id), $this->serviceManager);
        } catch (\Exception $exception) {
            return new ApiProblem($exception->getCode(), $exception->getMessage());
        }
    }

    /**
     * Fetch all or a subset of resources
     *
     * @param  array $params
     * @return ApiProblem|mixed
     */
    public function fetchAll($params = [])
    {
        try {
            return new ArticleCollection($this->articleService->getArticles($params), $this->serviceManager);
        } catch (\Exception $exception) {
            return new ApiProblem($exception->getCode(), $exception->getMessage());
        }
    }
}
