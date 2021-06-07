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
	protected function showAll(Collection $collection,$code=200)
	{
		return $this->successResponse(["data"=>$collection],$code);
	}

	//return a single element of a model
	protected function showOne(Model $model,$code=200)
	{
		return $this->successResponse(["data"=>$model],$code);
	}
}
?>