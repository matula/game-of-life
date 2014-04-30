<?php
session_start();

// How big?
$grid_size = 20;
$starting_cells = [];
$cells = [];
$total_alive = 0;
$same_grid = false;

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
?>

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
