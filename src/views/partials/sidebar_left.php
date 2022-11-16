<aside class="sidebar-left">
    <div>
        <h3>CATEGORÍAS</h3>

        <ul>
            <?php foreach (CategoryRepository::getAllCategories() as $category): ?>
                <li>
                    <button class="aside-category" data-id="<?php echo $category->getId(); ?>">
                        <?php echo $category->getName(); ?>
                    </button>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
    <div>
        <h3>TAGS</h3>
        <p>Obtener los tags más usados</p>
        <p>Problema: el contador de los tags no está programado</p>

        <ul>
        </ul>
    </div>
</aside>