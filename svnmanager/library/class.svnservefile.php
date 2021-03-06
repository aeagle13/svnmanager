<?php

require_once('svnmanager/global/Security.php');

class SVNServeFile 
{

	private $database;
	
	function __construct() 
	{
		require("config.php");		
		$this->database = new TAdodb;
		$this->database->setDataSourceName($dsn);		
	}
	
	private function getUserName($userid)
	{
		$user = $this->database->Execute("SELECT * FROM users WHERE id=" . makeSqlString($userid));
		if($user)
			return $user->fields['name'];
		else
			return null;
	}


	/*
	 * Access:
	 * 0 = no access
	 * 1 = r 
	 * 2 = w 
	 * 3 = rw
	 */
	public function createFromDatabase() 
	{
		require ("config.php");

		if (!isset($svnserve_user_file)) return;

		$filename = $svnserve_user_file;

		$accessfile = "## This SVNServe user file generated by SVNManager\n[users]\n";

		$accessfile .= "\n";

		$userresults = $this->database->Execute("SELECT * FROM users ORDER BY name");
	
		while(!$userresults->EOF)
		{
      $id = $userresults->fields['id'];
      $password = $this->database->Execute("SELECT * FROM svnserve_pwd WHERE ownerid=" . makeSqlString($id));
      if ($password->RecordCount() > 0)
      {
        $accessfile .= $userresults->fields['name']." = ".str_rot13($password->fields['password'])."\n";
      }
			$userresults->MoveNext();
		}
		$userresults->Close();

		if (!$handle = fopen($filename, 'w')) {
			echo "Cannot open file ($filename)";
			exit;
		}
		if (fwrite($handle, $accessfile) === FALSE) {
			echo "Cannot write to file ($filename)";
			exit;
		}

		fclose($handle);

	}

}
