<?php namespace Nova\Foundation\Support\Facades;

use Nova\Core\Contracts\ResourceInterface;
use Nova\Core\Contracts\CollectionInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Illuminate\Support\Facades\Response as LaravelResponse;

class Response extends LaravelResponse {

	/**
	 * Return a new JSON response from the application.
	 * Including ETag for the given resource.
	 *
	 * @param	ResourceInterface	Resource
	 * @param	array				Data to be used
	 * @param	int					Status code
	 * @param	array				Response headers
	 * @return	JsonResponse
	 */
	public static function resourceJson(ResourceInterface $resource, $data = [], $status = 200, array $headers = [])
	{
		$data[$resource->getResourceName()] = $resource->toArray();

		$response = new JsonResponse($data, $status, $headers);
		$response->setEtag($resource->getEtag());

		return $response;
	}

	/**
	 * Return a new JSON response from the application.
	 * Including ETag for given collection of resources.
	 *
	 * @param	CollectionInterface	A collection
	 * @param	array				Array of data
	 * @param	int					Status code
	 * @param	array				Response headers
	 * @return	JsonResponse
	 */
	public static function collectionJson(CollectionInterface $collection, $data = [], $status = 200, array $headers = [])
	{
		$data[$collection->getCollectionName()] = $collection->toArray();

		$response = new JsonResponse($data, $status, $headers);
		$response->setEtag($collection->getEtags());

		return $response;
	}

}