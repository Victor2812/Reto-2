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
        <ul class="tags-list">
            <?php foreach (TagRepository::getAllTags() as $tag): ?>
                <li>
                    <button class="tag" data-id="<?php echo $tag->getId(); ?>">
                        <?php echo $tag->getName(); ?>
                    </button>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
</aside>