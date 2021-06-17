<?php

namespace App\Traits;

use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;

trait ApiResponser{
	protected function successResponse($data,$code)
	{
		return response()->json($data,$code);
	}

	protected function errorResponse($message,$code)
	{
		return response()->json(["error"=>$message,"code"=>$code]);
	}

	//return a list of elements of a model
	protected function showCollectionAsResponse(Collection $collection,$code=200)
	{
		if($collection->isEmpty())
		{
			return $this->successResponse(["data"=>$collection],$code);
		}
		$transformer=$collection->first()->transformer;
		$collection=$this->transformData($collection,$transformer);
		return $this->successResponse(["data"=>$collection],$code);
	}

	//return a single element of a model
	protected function showModelAsResponse(Model $model,$code=200)
	{
		$transformer=$model->transformer;
		$model=$this->transformData($model,$transformer);
		return $this->successResponse(["data"=>$model],$code);
	}

	protected function transformData($data,$transformer)
	{
		return fractal($data, new $transformer)->toArray();
	
	}

}
?>