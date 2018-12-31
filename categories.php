<!DOCTYPE html>
<html>
    <?php include_once('head.php'); ?>
    <body>
        <?php include_once('nav.php'); ?>

        <div class="content">
            <?php
                if ($_SERVER['REQUEST_METHOD'] == 'GET') {
                    if (isset($_GET['to']) && (isset($_GET['headCategory']) || isset($_GET['subCategory']))) {
                        if (isset($_GET['headCategory'])) {
                            DB::update('headCategories', array('name' => $_GET['to']), 'id=%d', intVal($_GET['headCategory']));
                            if (DB::affectedRows() === 1) echo '<div class="alert alert-info" role="alert"><p>Kategorie umbennant.</p></div>';
                        } else {
                            DB::update('subCategories', array('name' => $_GET['to']), 'id=%d', intVal($_GET['subCategory']));
                            if (DB::affectedRows() === 1) echo '<div class="alert alert-info" role="alert"><p>Unterkategorie umbennant.</p></div>';
                        }
                    } else if (isset($_GET['removeCategory']) && !empty($_GET['removeCategory'])) {
                        DB::delete('headCategories', "id=%d", intVal($_GET['removeCategory']));
                        if (DB::affectedRows() === 1) echo '<div class="alert alert-info" role="alert"><p>Kategorie entfernt.</p></div>';
                    } else if (isset($_GET['removeSubcategory']) && !empty($_GET['removeSubcategory'])) {
                        DB::delete('subCategories', "id=%d", intVal($_GET['removeSubcategory']));
                        if (DB::affectedRows() === 1) echo '<div class="alert alert-info" role="alert"><p>Unterkategorie entfernt.</p></div>';
                    }

                    $headCategories = DB::query('SELECT id, name, amount FROM headCategories ORDER BY name ASC');
                    $subCategories = DB::query('SELECT id, name, amount FROM subCategories ORDER BY name ASC');

                    echo '<hr/><ul class="categories list-group"><li class="alert alert-info"><span class="list-span">Kategorien</span><span class="list-span">Anzahl</span><span class="list-span">Aktionen</span></li>';
                    foreach ($headCategories as $category) {
                        printf('<li class="list-group-item"><a name="removeCategory" data-name="%s" href="categories.php?removeCategory=%d" class="removalButton fas fa-times-circle btn"></a><a class="list-span" data-name="%s" href="inventory.php?category=%d">%s</a><span class="list-span">%d %s</span><a class="fas fa-edit editCategory" href="categories.php" name="editCategory" data-name="%s" data-id="%d"></a></li>', $category['name'], $category['id'], $category['name'], $category['id'], $category['name'], $category['amount'], $category['amount'] == 1 ? 'Gegenstand' : 'Gegenstände', $category['name'], $category['id']);
                    }
                    echo '</ul><hr/>';

                    echo '<ul class="categories list-group"><li class="alert alert-info"><span class="list-span">Unterkategorien</span><span class="list-span">Anzahl</span><span class="list-span">Aktionen</span></li>';
                    foreach ($subCategories as $category) {
                        printf('<li class="list-group-item"><a name="removeSubcategory" data-name="%s" href="categories.php?removeSubcategory=%d" class="removalButton fas fa-times-circle btn"></a><a class="list-span" data-name="%s" href="inventory.php?subcategory=%d">%s</a><span class="list-span">%d %s</span><a class="fas fa-edit editCategory" href="categories.php" name="editSubcategory" data-name="%s" data-id="%d"></a></li>', $category['name'], $category['id'], $category['name'], $category['id'], $category['name'], $category['amount'], $category['amount'] == 1 ? 'Gegenstand' : 'Gegenstände', $category['name'], $category['id']);
                    }

                    echo '</ul>';
                }
            ?>
        </div>

        <?php include_once('footer.php'); ?>

        <script type="text/javascript">
            let removalButtons = document.querySelectorAll('.removalButton')
            for (let button of removalButtons) {
                button.addEventListener('click', function (evt) {
                    let targetType = evt.target.name === 'removeCategory' ? 'Kategorie' : 'Unterkategorie'
                    if (!window.confirm(targetType + ' "' + evt.target.dataset['name'] + '" wirklich entfernen?')) {
                        evt.preventDefault()
                    }
                })
            }

            let editCategoryButtons = document.querySelectorAll('.editCategory')
            for (let button of editCategoryButtons) {
                button.addEventListener('click', function (evt) {
                    let targetType = evt.target.name === 'editCategory' ? 'Kategorie' : 'Unterkategorie'
                    let newName = window.prompt(targetType + ' "' + evt.target.dataset['name'] + '" umbenennen?', '')

                    if (newName !== null && newName.length !== 0) {
                        if (evt.target.name === 'editCategory') window.location.href = 'categories.php?headCategory=' + evt.target.dataset['id'] +  '&to='+ newName
                        else window.location.href = 'categories.php?subCategory=' + evt.target.dataset['id'] +  '&to='+ newName
                        return
                    }

                    evt.preventDefault()
                    return false
                })
            }
        </script>
    </body>
</html>