<?php
session_start();

// How big?
$grid_size = 20;
$starting_cells = [];
$cells = [];
$total_alive = 0;
$same_grid = false;

// Reset Game
if (isset($_GET['new'])) {
    unset($_SESSION['cells']);
}

// Set the grid
if (isset($_SESSION['cells'])) {
    $starting_cells = $_SESSION['cells'];
} else {
    // Initial grid
    // The rows
    for ($ci = 1; $ci <= $grid_size; $ci++) {
        // The columns
        for ($cr = 1; $cr <= $grid_size; $cr++) {
            // Should only be about 30% of the spaces as occupied
            $starting_cells[$ci][$cr] = (rand(0, 10) > 7) ? 1 : 0;
        }
    }
}
?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Conway's Game of Life in PHP, by Terry Matula">
    <meta name="author" content="Terry Matula">

    <title>Matula's Game of Life in PHP</title>
    <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css">
    <style>
        table#game-grid {
            border-collapse: collapse;
        }

        table#game-grid td {
            border: 1px solid #999;
            width: 30px;
            height: 30px;
        }

        .alive {
            background: #3f4c6b; /* Old browsers */
            background: -moz-linear-gradient(top, #3f4c6b 0%, #545a68 100%); /* FF3.6+ */
            background: -webkit-gradient(linear, left top, left bottom, color-stop(0%, #3f4c6b), color-stop(100%, #545a68)); /* Chrome,Safari4+ */
            background: -webkit-linear-gradient(top, #3f4c6b 0%, #545a68 100%); /* Chrome10+,Safari5.1+ */
            background: -o-linear-gradient(top, #3f4c6b 0%, #545a68 100%); /* Opera 11.10+ */
            background: -ms-linear-gradient(top, #3f4c6b 0%, #545a68 100%); /* IE10+ */
            background: linear-gradient(to bottom, #3f4c6b 0%, #545a68 100%); /* W3C */
            filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#3f4c6b', endColorstr='#545a68', GradientType=0); /* IE6-9 */
        }
    </style>
</head>
<body>

<div class="container">
    <div class="header">
        <h3 class="text-muted">Matula's Game of Life</h3>
    </div>
    <div class="row marketing">
        <div class="col-lg-12">
            An implementation of <a href="http://en.wikipedia.org/wiki/Conway's_Game_of_Life">Conway's Game of Life</a>
            in PHP just as a personal coding excercise.  It's all very procedural.<br>
            <a class="btn btn-default" href="https://github.com/matula/game-of-life">Github</a>
        </div>
    </div>
    <div class="row marketing">
        <div class="col-lg-12">
            <table id="game-grid">
                <?php for ($row = 1; $row <= $grid_size; $row++): ?>
                    <tr>
                        <?php for ($col = 1; $col <= $grid_size; $col++): ?>
                            <?php $cells[$row][$col] = checkSurroundingCells($starting_cells, $row, $col) ?>
                            <?php $total_alive += $starting_cells[$row][$col] ?>
                            <td class="<?php echo ($starting_cells[$row][$col]) ? 'alive' : '' ?>">&nbsp;</td>
                        <?php endfor; ?>
                    </tr>
                <?php endfor; ?>
                <?php if (isset($_SESSION['cells']) and $_SESSION['cells'] == $cells): ?>
                    <?php $same_grid = true; ?>
                <?php endif; ?>
                <?php $_SESSION['cells'] = $cells; ?>
            </table>
            <?php if ($same_grid): ?>
                <hr>
                <h2>Nothing else to do.</h2>
                <?php unset($_SESSION['cells']) ?>
            <?php endif; ?>
            <?php if ($total_alive == 0): ?>
                <hr>
                <h2>Everyone Died.</h2>
                <?php unset($_SESSION['cells']) ?>
            <?php endif; ?>
            <hr>
            <a href="./?new=true" class="btn btn-default">Clear</a> <a href="./" class="btn btn-success">Next</a>
        </div>
    </div>

</div>
</div>

</body>
</html>

<?php

function checkSurroundingCells($cells, $cell_row, $cell_col)
{
    $cells_total = addCells($cells, $cell_row, $cell_col);
    if (($cells[$cell_row][$cell_col] == 1 and $cells_total == 2) or $cells_total == 3) {
        return 1;
    }

    return 0;
}

function addCells($cells, $cell_row, $cell_col)
{
    $add_cells = 0;
    $add_cells += calculateCellValue($cells, $cell_row - 1, $cell_col - 1);
    $add_cells += calculateCellValue($cells, $cell_row - 1, $cell_col);
    $add_cells += calculateCellValue($cells, $cell_row - 1, $cell_col + 1);
    $add_cells += calculateCellValue($cells, $cell_row, $cell_col - 1);
    $add_cells += calculateCellValue($cells, $cell_row, $cell_col + 1);
    $add_cells += calculateCellValue($cells, $cell_row + 1, $cell_col - 1);
    $add_cells += calculateCellValue($cells, $cell_row + 1, $cell_col);
    $add_cells += calculateCellValue($cells, $cell_row + 1, $cell_col + 1);

    return $add_cells;
}

function calculateCellValue($cells, $row, $col)
{
    return isset($cells[$row][$col]) ? $cells[$row][$col] : 0;
}
