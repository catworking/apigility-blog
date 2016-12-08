<?php
namespace ApigilityBlog\V1\Rest\Category;

use ApigilityCatworkFoundation\Base\ApigilityResource;
use Zend\ServiceManager\ServiceManager;
use ZF\ApiProblem\ApiProblem;

class CategoryResource extends ApigilityResource
{
    /**
     * @var \ApigilityBlog\Service\CategoryService
     */
    protected $categoryService;

    /**
     * @var \ApigilityUser\Service\UserService
     */
    protected $userService;

    public function __construct(ServiceManager $services)
    {
        parent::__construct($services);
        $this->categoryService = $services->get('ApigilityBlog\Service\CategoryService');
        $this->userService = $services->get('ApigilityUser\Service\UserService');
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
            $parent = null;
            if (isset($data->category_id)) {
                $parent = $this->categoryService->getCategory($data->category_id);
            }
            return new CategoryEntity($this->categoryService->createCategory($data->name, $parent, $user), $this->serviceManager);
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
            $user = $this->userService->getAuthUser();
            return $this->categoryService->deleteCategory($id, $user);
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
            return new CategoryEntity($this->categoryService->getCategory($id), $this->serviceManager);
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
            return new CategoryCollection($this->categoryService->getCategories($params), $this->serviceManager);
        } catch (\Exception $exception) {
            return new ApiProblem($exception->getCode(), $exception->getMessage());
        }
    }
}
