<?php

namespace App\Repository;

use Illuminate\Database\Eloquent\Model;

abstract class AbstractRepository
{
	/**
	 * @var Model
	 */
	private $model;

	public function __construct(Model $model)
	{
		$this->model = $model;
	}

	public function selectCoditions($conditions)
	{
      // Ex.: /api/v1/search?conditions=property_area:=:200
      // Ex.: /api/v1/search?conditions=property_area:=:200&fields=title,content
		$expressions = explode(';', $conditions);
		foreach($expressions as $e) {
			$exp = explode(':', $e);

			$this->model = $this->model->where($exp[0], $exp[1], $exp[2]);
		}
	}

	public function selectFilter($filters)
	{
		$this->model = $this->model->selectRaw($filters);
	}

	public function getResult()
	{
		return $this->model;
	}
}