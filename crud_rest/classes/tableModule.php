<?php
require_once "singleton.php";


abstract class TableModule
{
	abstract protected function getTableName(): string;

	/**
	 * @param int $id
	 * @throws PDOException
	 */
	public function delete($id)
	{

		$sql = "DELETE FROM " . $this->getTableName() . " WHERE id=:id";
		$query = Singleton::prepare($sql);
		if (!$query->execute(array(":id" => $id))) {
			throw new PDOException("При удалении произошла ошибка");
		}
	}
	/**
	 * @param array $fields
	 * @return array
	 */
	public function read($fields = array())
	{
		$sql = "SELECT * FROM " . $this->getTableName() . " WHERE 1 ";
		foreach ($fields as $key => $field) {
			$sql .= "AND " . $key . "=" . $field . " ";
		}
		$query = Singleton::prepare($sql);
		$query->execute([]);
		$result = array();
		while ($slice = $query->fetch()) {
			$result[] = $slice;
		}
		return $result;
	}

	/**
	 * @param array $fields
	 * @throws PDOException
	 */
	public function create($fields)
	{
		$keys = [];
		$keyparam = [];
		$arField = [];
		foreach ($fields as $key => $field) {
			$keys[] = " " . $key;
			$keyparam[] = " :" . $key;
			$arField[":" . $key] = $field;
		}
		$keys = implode(", ", $keys);
		$keys = "(" . $keys . ")";
		$keyparam = implode(", ", $keyparam);
		$keyparam = "(" . $keyparam . ")";
		$sql = "INSERT INTO " . $this->getTableName() . " " . $keys . " VALUES " . $keyparam;
		$query = Singleton::prepare($sql);
		if (!$query->execute($arField)) {
			throw new PDOException("При добавлении произошла ошибка");
		}
	}
	/**
	 * @param array $fields
	 * @throws PDOException
	 */
	public function update($fields)
	{
		$keyparam = [];
		$arField = [];
		foreach ($fields as $key => $field) {
			if ($key != "id") {
				$keyparam[] = " `$key`=:" . $key;
			}
			$arField[":" . $key] = $field;
		}
		$keyparam = implode(", ", $keyparam);
		$sql = "UPDATE " . $this->getTableName() . " SET " . $keyparam . " WHERE id=:id";
		$query = Singleton::prepare($sql);
		if (!$query->execute($arField)) {
			throw new PDOException("При обновлении произошла ошибка");
		}
	}

	/**
	 * @param int $id
	 * @return bool
	 */
	public function exists($id): bool
	{
		$query = Singleton::prepare("SELECT * FROM " . $this->getTableName() . " WHERE id=" . $id);
		$query->execute([]);
		$find = $query->fetch();
		return boolval($find);
	}


	/**
	 * @return int
	 */
	public function lastID():int
	{
		$query = Singleton::prepare("SELECT MAX(ID) FROM " . $this->getTableName());
		$query->execute([]);
		$find = $query->fetch();
		return intval($find["MAX(ID)"]);
	}

    public function get($id)
    {
        $query = Singleton::prepare("SELECT * FROM " . $this->getTableName() . " WHERE id=:id");
        $query->execute(array(":id" => $id));
        return $query->fetch();
    }

    public function getRecordsByFilter($material, $fields = array())
    {
        $sql = "SELECT * FROM " . $this->getTableName() . " WHERE material=:material";
        foreach ($fields as $key => $field) {
            $sql .= " AND " . $key . " = :" . $key;
        }
        $query = Singleton::prepare($sql);
        $query->execute(array_merge(array(':material' => $material), $fields));
        $result = array();
        while ($slice = $query->fetch()) {
            $result[] = $slice;
        }
        return $result;
    }
}