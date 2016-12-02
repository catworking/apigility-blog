<?php
namespace ApigilityBlog\V1\Rest\Media;

use ZF\ApiProblem\ApiProblem;
use ZF\Rest\AbstractResourceListener;
use Zend\ServiceManager\ServiceManager;

class MediaResource extends AbstractResourceListener
{
    /**
     * @var \ApigilityBlog\Service\MediaService
     */
    protected $mediaService;

    /**
     * @var \ApigilityUser\Service\UserService
     */
    protected $userService;

    public function __construct(ServiceManager $services)
    {
        $this->mediaService = $services->get('ApigilityBlog\Service\MediaService');
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
            return new MediaEntity($this->mediaService->createMedia($data, $user));
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
            return $this->mediaService->deleteMedia($id, $user);
        } catch (\Exception $exception) {
            return new ApiProblem($exception->getCode(), $exception->getMessage());
        }
    }

    /**
     * Delete a collection, or members of a collection
     *
     * @param  mixed $data
     * @return ApiProblem|mixed
     */
    public function deleteList($data)
    {
        return new ApiProblem(405, 'The DELETE method has not been defined for collections');
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
            return new MediaEntity($this->mediaService->getMedia($id));
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
            return new MediaCollection($this->mediaService->getMedias($params));
        } catch (\Exception $exception) {
            return new ApiProblem($exception->getCode(), $exception->getMessage());
        }
    }

    /**
     * Patch (partial in-place update) a resource
     *
     * @param  mixed $id
     * @param  mixed $data
     * @return ApiProblem|mixed
     */
    public function patch($id, $data)
    {
        return new ApiProblem(405, 'The PATCH method has not been defined for individual resources');
    }

    /**
     * Patch (partial in-place update) a collection or members of a collection
     *
     * @param  mixed $data
     * @return ApiProblem|mixed
     */
    public function patchList($data)
    {
        return new ApiProblem(405, 'The PATCH method has not been defined for collections');
    }

    /**
     * Replace a collection or members of a collection
     *
     * @param  mixed $data
     * @return ApiProblem|mixed
     */
    public function replaceList($data)
    {
        return new ApiProblem(405, 'The PUT method has not been defined for collections');
    }

    /**
     * Update a resource
     *
     * @param  mixed $id
     * @param  mixed $data
     * @return ApiProblem|mixed
     */
    public function update($id, $data)
    {
        return new ApiProblem(405, 'The PUT method has not been defined for individual resources');
    }
}
