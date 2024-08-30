<?php
class SQLConnect
{
	private $host = 'localhost';
	private $name = 'csdl';
	private $user = 'root';
	private $pass = '';
	public function connect()
	{
		try {
			$conn = new PDO(
				'mysql:host=' . $this->host . '; dbname=' . $this->name,
				$this->user,
				$this->pass
			);
			$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			return $conn;
		} catch (PDOException $e) {
			echo 'Database Error: ' . $e->getMessage();
		}
	}
}
