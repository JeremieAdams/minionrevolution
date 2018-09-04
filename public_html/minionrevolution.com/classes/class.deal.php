<?php

/*
	Class:		
	Author:		Jeremie M Adams
	Project:	ISKino.com
	Date: 		1/7/2015
	Status:		Untested
	T B C :		
*/


class Deal {

	/*	Attributes	*/
	
	private $players;
	private $tableID;
	private $dealArray;
	private $flopOffset;
	private $handStrength;
	
	/*	Methods		*/
	
	private function Shuffle() {
		$pick = mt_rand(0, 51);
		$this->dealArray[0] = $pick;

		for ($i = 1, $c = count($this->dealArray) ; $i < $c ; $i++) {
			$flag = true;
			while ($flag) {
				$flag = false;
				$pick = mt_rand(0, 51);
				for ($j = 0, $c = count($this->dealArray) ; $j < $c ; $j++) {
					if ($this->dealArray[$j] == $pick) {
						$flag = true;
					}
				}
			}
			$this->dealArray[$i] = $pick;
		}
	}
	
	private function DetermineHandStrengths() {
		$checkOffset = ($this->players * 2) + 1;
		$communityCards = array_fill(0, 5, -1);
		$flop = $this->GetFlop();
		
		$communityCards[0] = $flop['a'];
		$communityCards[1] = $flop['b'];
		$communityCards[2] = $flop['c'];
		
		echo "<br>";
		
		$communityCards[3] = $this->GetTurn();
		$communityCards[4] = $this->GetRiver();
		
		for ($i = 0; $i < $this->players; $i++) {
			$holdCards = $this->GetPlayerCard($i);
			$playerHand = array($holdCards[0], $holdCards[1], $communityCards[0], $communityCards[1], $communityCards[2], $communityCards[3], $communityCards[4]);
			$modArray = array_fill(0, 7, -1);
			$flushArray = array_fill(0, 7, -1);

			for ($k = 0 ; $k < 7; $k++) {
				$modArray[$k] = $playerHand[$k] % 13;
			}

			for ($k = 0 ; $k < 7; $k++) {
				$flushArray[$k] = intval($playerHand[$k] / 13);
			}
			
			//sort($playerHand);
			sort($modArray);
			
			for ($k = 0 ; $k < 7; $k++) {
				echo $playerHand[$k] . " ";
			}
			echo "<br>";
		}
		echo "<br><br><br>";
	}
	
	function PrintHand() {
		echo $this->players . " " . $this->tableID . " " . $this->flopOffset . " " . count($this->dealArray) . "<br>";
		for ($i = 0; $i < count($this->dealArray); $i++) {
			echo $this->dealArray[$i] . " ";
		}
		echo "<br>";
	}
	
	////***	Constructor

	function __construct($NoPlayers, $IDtable) {
		$this->players = $NoPlayers;
		$this->tableID = $IDtable;
		$cardNeed = $NoPlayers * 2;
		$cardNeed += 8;
		$this->dealArray = array_fill(0, $cardNeed, -1);
		$this->Shuffle();
		$this->flopOffset = ($NoPlayers * 2) + 1;
		$this->PrintHand();
		$this->DetermineHandStrengths();
	}

	////***	Modifier Functions
	
	////***	Set Functions

	////***	Get Functions

	function GetPlayers() {
		return $this->players;
	}
	
	function GetTableID() {
		return $this->tableID;
	}
	
	function GetPlayerCard($seatNO) {
		$cards = array_fill(0, 2, -1);
		$cards[0] = $this->FetchCard($seatNO);
		$cards[1] = $this->FetchCard($seatNO + $this->players);
		return $cards;
	}
	
	private function FetchCard ($cardNO){
		return $this->dealArray[$cardNO];
	}

	function GetFlop() {
		$cards = array_fill(0, 3, -1);
		$cards['a'] = $this->FetchCard($this->flopOffset);
		$cards['b'] = $this->FetchCard($this->flopOffset + 1);
		$cards['c'] = $this->FetchCard($this->flopOffset + 2);
		return $cards;
	}

	function GetTurn () {
		return $this->FetchCard($this->flopOffset + 4);
	}

	function GetRiver () {
		return $this->FetchCard($this->flopOffset + 6);
	}
	
}//Close Class function
?>
