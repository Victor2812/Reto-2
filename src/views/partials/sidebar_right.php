<?php

    $user = $GLOBALS['session']->getCurrentUser();

?>

<aside class="sidebar-right">
    <div>
        <h3>puntos</h3>
        <p class="points"><?php echo $GLOBALS['session']->getCurrentUser()->getPoints() ?></p>
    </div>
    <div>
        <h3>seguidos</h3>
        <ul>
            <?php foreach (UserRepository::getFollowingInfo($user) as $following): ?>
                <li><a href="#" class="flex-container"><img src="../img/user-default-image.svg" alt="user_img" class="author-icon"> <?php echo $following->getUsername(); ?></a></li>
            <?php endforeach; ?>
        </ul>
    </div>
    <div>
        <h3>seguidores</h3>
        <ul>
            <?php foreach (UserRepository::getFollowersInfo($user) as $follower): ?>
                <li><a href="#" class="flex-container"><img src="../img/user-default-image.svg" alt="user_img" class="author-icon"> <?php echo $follower->getUsername(); ?></a></li>
            <?php endforeach; ?>
        </ul>
    </div>
    <div class="ranking">
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
    </div>
</aside>
