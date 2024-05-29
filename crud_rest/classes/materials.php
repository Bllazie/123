<?php
require_once "tableModule.php";

class Materials extends TableModule
{
	protected function getTableName(): string
	{
		return "material";
	}
}