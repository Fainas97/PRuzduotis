<?php
session_start();
require_once('load.php');
$database = new Database();

if (isset($_GET['page'])) {
    $pageno = $_GET['page'];
} else {
    $pageno = 1;
}

$rows_per_page = config::ROWS_PAGE;

if (isset($_GET['search']) && !empty($_GET['search'])) {
    $search = $_GET['search'];
    $link = "?search=" . $_GET['search'] . "&";
    $total_pages = ceil($database->getSearchedCountriesCount($_GET['search']) / $rows_per_page);
    $countries = $database->searchCountries($_GET['search'], $pageno, $rows_per_page);
} else {
    $search = "";
    $link = "?";
    $total_pages = ceil($database->getCountriesCount() / $rows_per_page);
    $countries = $database->getCountries($pageno, $rows_per_page);
}

include_once('header.php') ?>
<div class="container">
    <label>Pridėti šalį</label>
    <form action="add_countries.php" method="post">
        <label>Pavadinimas:
            <input type="text" name="name">
        </label>
        <button type="submit">Pridėti</button>
    </form>
    <label>Šalies paieška</label>
    <form action="countries.php" method="get">
        <label>Paieška:
            <input type="text" name="search" value="<?php echo $search; ?>">
        </label>
        <button type="submit">Ieškoti</button>
    </form>
    <?php if (mysqli_num_rows($countries) != 0) { ?>
        <table>
            <thead>
            <tr>
                <td>Šalis</td>
                <td>Trinti</td>
            </tr>
            </thead>
            <tbody>
            <?php while ($country = mysqli_fetch_assoc($countries)) { ?>
                <tr>
                    <td><a href="cities.php?id=<?php echo $country['ID'] ?>"><?php echo $country['Salis'] ?></a></td>
                    <td>
                        <form action="delete_countries.php" method="post">
                            <input type="hidden" name="country_id" value="<?php echo $country['ID']; ?>">
                            <button type="submit">Trinti</button>
                        </form>
                    </td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
        <?php if ($total_pages > 1) {?>
        <ul class="pagination">
            <li><a href="<?php echo $link; ?>page=1">Pradinis</a></li>
            <li class="<?php if ($pageno <= 1) {echo 'disabled';} ?>">
                <a href="<?php if ($pageno <= 1) {echo '#';}
                else { echo $link . "page=" . ($pageno - 1);} ?>">Praeitas<?php if ($pageno > 1){ echo " - "; echo $pageno - 1; }?></a>
            </li>
            <li class="<?php if ($pageno >= $total_pages) {echo 'disabled';} ?>">
                <a href="<?php if ($pageno >= $total_pages) {echo '#';}
                else { echo $link . "page=" . ($pageno + 1);} ?>">Kitas<?php if ($pageno < $total_pages) { echo " - "; echo $pageno + 1; } ?></a>
            </li>
            <li><a href="<?php echo $link; ?>page=<?php echo $total_pages ?>">Paskutinis - <?php echo $total_pages?></a></li>
        </ul>
        <?php }?>
    <?php } else echo "Šalių nėra" ?>
    <?php if (!empty($_SESSION['error'])) { ?>
        <div class='error'><?php echo $_SESSION['error'] ?></div>
        <?php $_SESSION['error'] = array();
    } else if (isset($_SESSION) && $_SESSION['success'] == 1) { ?>
        <div class='success'>Operacija atlikta!</div>
        <?php $_SESSION['success'] = 0; } ?>
</div>
</body>
</html>