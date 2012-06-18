<?php

// N-Queens problem: put N Queens on a chess board NxN 
// sized such that they aren't at risk of capture

class Queens
{
	private $board = array();
	private $numQueens = 8;
	
	public function __construct($n = 8)
	{
		$this->numQueens = $n;
		
		// Fill the board with 0s
		for($i = 0; $i < $n; $i++)
		{
			$this->board[$i] = array_fill(0, $n, 0);
		}
	}
	
	function solve($queenNum, $row)
	{
		for($col = 0; $col < $this->numQueens; $col++)
		{
			if($this->allowed($row, $col))
			{
				// if this cell is allowed, set the queen here
				$this->board[$row][$col] = 1;
				
				// If last queen or subsequent queens have been placed, return
				if(($queenNum === $this->numQueens - 1) || $this->solve($queenNum + 1, $row + 1) === true) return true;
				
				// otherwise, if we get here we've backtracked and have to try replacing this queen
				$this->board[$row][$col] = 0;
			}
		}
		
		return false;
	}
	
	function allowed($x, $y)
	{
		$n = $this->numQueens;
		
		// Only test as far as the row being entered because there will never
		// be a situation where a Queen is moved behind other Queens.
		// Any further rows will all be empty.
		for($i = 0; $i < $x; $i++)
		{
			// test the column to check for another Queen
			if($this->board[$i][$y] === 1) return false;
			
			// Test the diagonals (backwards from the coordinate)
			$tx = $x - 1 - $i;
			$ty = $y - 1 - $i;	// diagonal this way \
			if(($ty >= 0) && ($this->board[$tx][$ty] === 1)) return false;
			
			$ty = $y + 1 + $i;	// diagonal this way /
			if(($ty < $n) && ($this->board[$tx][$ty] === 1)) return false;
		}
		
		return true;
	}
	
	// Rudimentary printing method
	function printBoard()
	{
		for($row=0; $row<$this->numQueens; $row++)
		{
			$sep = '-';
			for($col=0; $col<$this->numQueens; $col++)
			{
				$sep .= '--';	// for every column add 2 dashes to then print below the row
				echo '|';
				
				$cell = $this->board[$row][$col];
				if($cell === 1)
				{
					echo 'Q';
				}
				else
				{
					echo ' ';
				}
			}
			
			echo "|\n";
			echo $sep . "\n";	// print the seperator row -------
		}
	}
}

// Run main ...
$queens = new Queens(8);
$queens->solve(0, 0);

$queens->printBoard();

?>