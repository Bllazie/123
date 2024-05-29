<?php
require_once "tableModule.php";

class Earrings extends TableModule
{
    protected function getTableName(): string
    {
        return "earrings";
    }
}
