<?php
$number = (strlen($_POST['number1']) > 0)? strlen($_POST['number1']): 4;
$numberGame = new NumberGame($_POST['number1'], $_POST['number2'], $number);
$numberGame->doCheckNumber();
$answers = $numberGame->getAnswer();
?>
<form method="POST">
	瞦计<input type="password" value="<?=htmlspecialchars($numberGame->getQuestionNumberString()) ?>" name="number1" />&nbsp;&nbsp;
	块瞦代计<input type="text" value="<?=htmlspecialchars($numberGame->getKeyinNumberString()) ?>" name="number2" />
	<input type="submit" /><br/>
	<textarea name="content" cols="10" rows="30" ><?=sprintf("%dA%dB", $answers['A'], $answers['B'])."\r\n".htmlspecialchars($_POST['content']) ?></textarea>
</form>
<?php 
class NumberGame{

	/**
	 * 瞦代挡狦
	 * @param integer $answer['A'] 竚计
	 * @param integer $answer['B'] ぃ竚计
	 */
	public $answer = array( 'A' => 0, 'B' => 0 );

	/**
	 * 拜肈氮
	 * @param string
	*/
	private $questionNumber = array();

	/**
	 * ㄏノ瞦代氮
	 * @param string $keyinNumber
	 */
	private $keyinNumber = array();


	private $randNumber = array();

	public function __construct($questionNumberString = '', $keyinNumberString = '', $n = 4){
		if($questionNumberString == ''){
			$questionNumber = $this->getRandQuestionNumber(4);
		}else{
			$questionNumber = str_split($questionNumberString);
			$keyinNumber = str_split($keyinNumberString);
		}
		$this->setQuestionNumber($questionNumber);
		$this->setKeyinNumber($keyinNumber);
	}

	public function getRandQuestionNumber($n){
		$this->randNumber = range(0, 9);
		shuffle($this->randNumber);
		return array_slice($this->randNumber, $n);
	}

	public function getQuestionNumberString(){
		if(is_array($this->questionNumber)){
			return implode('', $this->questionNumber);
		}
	}
	
	public function setQuestionNumber($number){
		$this->questionNumber = $number;
	}

	public function getKeyinNumberString(){
		if(is_array($this->keyinNumber)){
			return implode('', $this->keyinNumber);
		}
	}
	
	public function setKeyinNumber($number){
		$this->keyinNumber = $number;
	}
	
	public function getAnswer(){
		return $this->answer;
	}
	
	public function doCheckNumber(){
		if(!empty($this->keyinNumber) && !empty($this->questionNumber)){
			$this->answer = $this->checkNumber($this->questionNumber, $this->keyinNumber);
		}
	}

	/**
	 * ゑ癸瞦计挡狦
	 * @param array $questionNumber 拜肈氮
	 * @param array $keyinNumber ㄏノ瞦代计
	 */
	private function checkNumber($questionNumber, $keyinNumber){
		$answers = array( 'A' => 0, 'B' => 0 );
		foreach ($keyinNumber as $k => $number){
			if($number == $questionNumber[$k]){
				$answers['A']++;
			}else if(in_array($number, $questionNumber)){
				$answers['B']++;
			}
		}
		return $answers;
	}

}