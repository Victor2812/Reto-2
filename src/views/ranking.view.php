<div class="content">
    <?php include "partials/sidebar_left.php"; ?>
    <main>
        <h3>RANKING</h3>
            <ul>
                <?php 
                    foreach (UserRepository::getRankingInfo() as $ranking) {
                        echo "<li class='flex-container'>
                            <div>".$ranking->getPoints()."</div>
                            <div>".$ranking->getUserName()."</div>
                            <div>".$ranking->getJob()."</div>
                        </li>";
                    }
                ?>
            </ul>
    </main>
    <?php include "partials/sidebar_right.php"; ?>
</div>
