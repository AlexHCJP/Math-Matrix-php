<?php


class Matrix
{
    public $matrix = [];
    public $length = 0;
    public $width = 0;
    public function __construct(array $matrix)
    {
        $maxCount = 0;
        $this->length = count($matrix);
        for($i = 0; $i < $this->length; $i++)
        {
            $maxCount = max(count($matrix[$i]), $maxCount);
        }
        $this->width = $maxCount;
        for($i = 0; $i < $this->length; $i++)
        {
            $countCurrentArr = count($matrix[$i]);
            if($maxCount > $countCurrentArr)
            {
                for($j = 0; $j < $maxCount - $countCurrentArr; $j++)
                {
                    $matrix[$i][] = 0;
                }
            }
        }
        $this->matrix = $matrix;
    }
    public function add(Matrix $matrix)
    {
        if($matrix->length == $this->length &&
            $matrix->width == $this->width)
        {
            for($i = 0; $i < $this->length; $i++)
            {
                for($j = 0; $j < $this->width; $j++)
                {
                    $this->matrix[$i][$j] += $this->matrix[$i][$j];
                }
            }
        }
        return $this;
    }
    public function diff(Matrix $matrix)
    {
        if($matrix->length == $this->length &&
            $matrix->width == $this->width)
        {
            for($i = 0; $i < $this->length; $i++)
            {
                for($j = 0; $j < $this->width; $j++)
                {
                    $this->matrix[$i][$j] -= $this->matrix[$i][$j];
                }
            }
        }
        return $this;
    }
    public function mult(Matrix $matrix)
    {
        $canMult = checkSizeMatrix($this, $matrix);
        if($canMult)
        {
            $newMatrix = new Matrix(createDoubleArrayBySize($canMult, $canMult));
            for($i = 0; $i < $this->length; $i++)
            {
                for($j = 0; $j < $this->length; $j++)
                {
                    $c = 0;
                    for($k = 0; $k < $this->width; $k++)
                    {
                        $c += $this->matrix[$i][$k] * $matrix->matrix[$k][$j];
                    }
                    $newMatrix->matrix[$i][$j] = $c;
                }
            }
            $this->matrix = $newMatrix->matrix;
            $this->width = $newMatrix->width;
            $this->length = $newMatrix->length;
            unset($newMatrix);
        }
        return $this;
    }
    function toArray()
    {
        return $this->matrix;
    }
}
function checkSizeMatrix(Matrix $matrix1, Matrix $matrix2)
{

    if($matrix1->length == $matrix2->width)
    {
        return $matrix1->length;
    }
    elseif($matrix1->width == $matrix2->length)
    {
        return $matrix1->width;
    }
    return false;
}
function createDoubleArrayBySize(int $length, int $width)
{
    $arr = [];
    for($i = 0; $i < $length; $i++)
    {
        for($j = 0; $j < $width; $j++)
        {
            $arr[$i][$j] = 0;
        }
    }
    return $arr;
}
$mat = new Matrix([[1,2,4],[2,0,3]]);
$mati = new Matrix([[2,5],[1,3],[1,1]]);
echo '<pre>';
print_r($mati->mult($mat));
echo '</pre>';