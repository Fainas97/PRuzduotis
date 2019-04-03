<?php
session_start();
require_once('load.php');
$db = new Database();

if (isset($_GET['page'])) {
    $pageno = $_GET['page'];
} else {
    $pageno = 1;
}

$country_id = $_GET['id'];
$rows_per_page = config::ROWS_PAGE;

if (isset($_GET['search']) && !empty($_GET['search'])) {
    $search = $_GET['search'];
    $link = "?id=" . $country_id . "&search=" . $_GET['search'] . "&";
    $total_pages = ceil($db->getSearchedCitiesCount($country_id, $_GET['search']) / $rows_per_page);
    $cities = $db->searchCities($country_id, $_GET['search'], $pageno, $rows_per_page);
} else {
    $search = "";
    $link = "?id=" . $country_id . "&";
    $total_pages = ceil($db->getCitiesCount($_GET['id']) / $rows_per_page);
    $cities = $db->getCities($country_id, $pageno, $rows_per_page);
}
$country = $db->getCountry($country_id);

include_once('header.php') ?>
<div class="container">
    <label>Pridėti miestą</label>
    <form action="add_cities.php" method="post">
        <input type="hidden" name="country_id" value="<?php echo $_GET['id'] ?>">
        <label>Pavadinimas:
            <input type="text" name="name">
        </label>
        <button type="submit">Pridėti</button>
    </form>
    <label>Miesto paieška</label>
    <form action="cities.php" method="get">
        <input type="hidden" name="id" value="<?php echo $country['ID']; ?>">
        <label>Paieška:
            <input type="text" name="search" value="<?php echo $search ?>">
        </label>
        <button type="submit">Ieškoti</button>
    </form>
    <?php if (mysqli_num_rows($cities) != 0) { ?>
        <table>
            <thead>
            <tr>
                <td colspan="2"><?php echo $country['Salis'] ?></td>
            </tr>
            <tr>
                <td>Miestas</td>
                <td>Trinti</td>
            </tr>
            </thead>
            <tbody>
            <?php while ($city = mysqli_fetch_assoc($cities)) { ?>
                <tr>
                    <td><?php echo $city['Miestas'] ?></td>
                    <td>
                        <form action="delete_cities.php" method="post" style="display: inline-block;">
                            <input type="hidden" name="country_id" value="<?php echo $country['ID']; ?>">
                            <input type="hidden" name="city_id" value="<?php echo $city['ID'] ?>">
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
                else { echo $link . "page=" . ($pageno + 1); } ?>">Kitas<?php if ($pageno < $total_pages) { echo " - "; echo $pageno + 1; } ?></a>
            </li>
            <li><a href="<?php echo $link; ?>page=<?php echo $total_pages ?>">Paskutinis - <?php echo $total_pages?></a></li>
        </ul>
        <?php }?>
    <?php } else echo 'Miestų nėra' ?> <br>
    <a href="countries.php">/--Šalys--\</a>
    <?php if (!empty($_SESSION['error'])) { ?>
    <div class='error'><?php echo $_SESSION['error'] ?></div>
    <?php $_SESSION['error'] = array();
    } else if (isset($_SESSION) && $_SESSION['success'] == 1) { ?>
    <div class='success'>Operacija atlikta!</div>
    <?php $_SESSION['success'] = 0; } ?>
</div>
</body>
</html>