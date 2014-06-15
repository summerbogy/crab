<?php
if (!defined('IS_INITPHP')) exit('Access Denied!');
/*********************************************************************************
 * InitPHP 3.3 ����PHP�������  Dao-pdo ����
 *-------------------------------------------------------------------------------
 * ��Ȩ����: CopyRight By initphp.com
 * ����������ʹ�ø�Դ�룬������ʹ�ù����У��뱣��������Ϣ�����������Ͷ��ɹ����������Լ�
 *-------------------------------------------------------------------------------
 * $Author:crab 
 * $Dtime:2014-4-27 
***********************************************************************************/
class pdoInit extends dbbaseInit{
	public $link_id; 				 //���Ӷ��� 
	protected $PDOStatement = null; //PDOStatement����
	protected $isPrepared = false; //�Ƿ��Ѿ�Ԥ����
	protected $numRows = '';      //��һ�β���Ӱ�������
	protected $transTimes = 0;	 //�������Ĵ���
	 
	/**
	 * MYSQL������
	 * @param  string $host sql������
	 * @param  string $user ���ݿ��û���
	 * @param  string $password ���ݿ��¼����
	 * @param  string $database ���ݿ�
	 * @param  string $charset ����
	 * @param  string $pconnect �Ƿ�־�����
	 * @return source
	 */
	 public function connect($host, $user, $password, $database, $charset = 'utf8', $pconnect = 0) {
		$options = array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES '" . $charset . "' ");
		$options_p = array(PDO::ATTR_PERSISTENT=>true, PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES '" . $charset . "' ");
		if($pconnect == 0) {
			$this->link_id = new PDO('mysql:host=' . $host . ';dbname=' . $database ,$user, $password, $options ); 
		}else{
			$this->link_id = new PDO('mysql:host=' . $host . ';dbname=' . $database, $user, $password, $options_p); 
		}
		$this->link_id->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);  
		//if (!$this->link_id) InitPHP::initError('pdo connect error!');		
		return $this->link_id;
	}
	/**
	 * SQLִ����
	 * @param  string $sql  SQL���
	 * @param  array  $bind ������
	 */
	public function query($sql, $bind = array()) {	//ͨ��	
		if(empty($bind)) {
			$this->PDOStatement = $this->link_id->query($sql);
		}else{
			if($this->PDOStatement) $this->free_result(); //�ͷ�ǰ�εĲ�ѯ���
			$this->PDOStatement = $this->link_id->prepare($sql, $bind);
			$this->bindPdoParam($bind);
			$result = $this->PDOStatement->execute();
		}
		$this->num_Rows();	
	}
	
	/**
	 * �ͷŽ���ڴ�
	 */
	public function free_result() {
		$this->PDOStatement = null;
	}
	
	/**
	 * �󶨲���
	 * @bind array 
	 */
	public function bindPdoParam($bind) {
		foreach ($bind as $name => &$value) {
            if (is_bool($value)) {
                $type = PDO::PARAM_BOOL;
            } elseif (is_int($value)) {
                $type = PDO::PARAM_INT;
            } else {
                $type = PDO::PARAM_STR;
            }
            $parameter = is_int($name) ? ($name + 1) : $name;
			$this->PDOStatement->bindParam($parameter, $value, $type);
        }	
	}
	
	/**
     * ִ�����
     * @access public
     * @param string $str  sqlָ��
     * @param array $bind ������
     * @return integer
     */
	public function execute($sql, $bind = array()){	 //ͨ��
		if (!$this->_linkID )   return false;
		if(!$this->isPrepared)  $this->prepare($sql);
		if($this->PDOStatement) $this->free_result(); //�ͷ�ǰ�εĲ�ѯ���
		if(!empty($bind))		$this->bindPdoParam($bind);        
        $result = $this->PDOStatement->execute();
		if($result === false) $this->error();
		$this->num_Rows();
	}
	
	/*
	 * ִ��Ԥ������� 
	 * @param string $sql Ԥ�����SQL���
	 * return void 
	 */
	public function prepare($sql){ //ͨ��
		if(!$this->link_id || $sql == '') return false;
		if($this->isPrepared) InitPHP::initError('This statement has been prepared already');
		$this->link_id->prepare($sql);
		$this->isPrepared = true;
	}
	
	 /**
     * @return bool
     */
    public function isPrepared() {
        return $this->isPrepared;
    }
	
	/**
	 * ��ʼ�������
 	 * DAO��ʹ�÷�����$this->dao->db->transaction_start()
	 */
	public function transaction_start() {
		if($this->transTimes > 1) return true;//����Ƕ��ʱֻ�ύ/�ع�����������
		if($this->transTimes == 0)  $this->link_id->beginTransaction();
		$this->transTimes++;
		return ;
	}

    /**
     * ���ڷ��Զ��ύ״̬����Ĳ�ѯ�ύ
     * @return boolen
     */
    public function transaction_commit() {
		if($this->transTimes > 1) return true; //����Ƕ��ʱֻ�ύ/�ع�����������
		if($this->transTimes > 0){
			$result = $this->link_id->commit();
			if(!$result)	return false;
			$this->transTimes = 0;
		}
        return true;
    }
	
	 /**
     * ����ع�
     * @return boolen
     */
    public function transaction_rollback() {
		if($this->transTimes > 1) return true; //����Ƕ��ʱֻ�ύ/�ع�����������
		if($this->transTimes > 0) {
			$result = $this->link_id->rallback();
			if(!$result) return false;
			$this->transTimes = 0;
		}
        return true;
    }
	
	/*
	 *���һ�в�ѯ���
	 *
	 */
	public function getResult($sql, $bind = false){
		$bind ? $this->query($sql,$bind) : $this->query($sql);
		return $this->fetch_assoc();
	}
	
	/*
	 *������в�ѯ���
	 *
	 */
	public function getAllResult($sql, $bind = false){
		$bind ? $this->query($sql,$bind) : $this->query($sql);
		return $this->fetch_all();
	}
	
	public function fetch_all(){
		if(!$this->PDOStatement) {
			$InitPHP_conf = InitPHP::getConfig();
			return $InitPHP_conf['is_debug'] ?	InitPHP::initError('PDOStatement is unexist') : false;
		} 
		return  $this->PDOStatement->fetchAll(PDO::FETCH_ASSOC);
	
	}
   

	/**
	 * ������е����� PDO֧�ִ˹���
	 * @return array
	 */
	public function result() {
		// Not needed for PDO
		$InitPHP_conf = InitPHP::getConfig();
		return $InitPHP_conf['is_debug'] ? InitPHP::initError('pdo unsuported this feature') : true; 
		return true;
	}
		
	/**
	 * �ӽ������ȡ��һ����Ϊ��������
	 * @return array
	 */
	public function fetch_assoc() {
		if(!$this->PDOStatement) return false;
		return  $this->PDOStatement->fetch(PDO::FETCH_ASSOC);
	}
	
	/**
	 * �ӽ������ȡ������Ϣ����Ϊ���󷵻�
	 * 
	 */
	public function fetch_fields() {
		// Not needed for PDO
		$InitPHP_conf = InitPHP::getConfig();
		return $InitPHP_conf['is_debug'] ? InitPHP::initError('pdo unsuported this feature') : true;	
	}
	
	
	/**
	 * ������е��ֶ�����
	 * @return int
	 */
	public function num_fields() {//ͨ��
		return $this->PDOStatement->columnCount();
	}
	
	/**
	 * ������е�����
	 * @return int
	 */
	public function num_rows() {//ͨ��
		if (is_int($this->numRows)) {
			return $this->numRows;
		}elseif(($this->numRows = $this->PDOStatement->rowCount()) > 0) {
			return $this->numRows;
		}else{
			$this->numRows = count($this->PDOStatement->fetchAll(PDO::FETCH_ASSOC));
			$this->PDOStatement->execute(); 
			return $this->numRows;
		}
	}
	/**
	 * ��ȡ��һINSERT��IDֵ
	 * @return Int
	 */
	public function insert_id($id = null) {
		return $this->link_id->lastInsertId($id) ;
	}
	
	/**
	 * ǰһ�β���Ӱ��ļ�¼��
	 * @return int
	 */
	public function affected_rows() {
		return $this->numRows;
	}
	
	/**
	 * �ر�����
	 * @return bool
	 */
	public function close() {//ͨ��
		if ($this->link_id !== NULL) $this->link_id = NULL;
		return true; 
	}
	
	/**
	 * ������Ϣ
	 * @return array
	 */
	public function error() {
		return $this->PDOStatement->errorInfo();
	}
	
	
}