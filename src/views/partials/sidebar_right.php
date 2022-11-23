<?php

    $user = $GLOBALS['session']->getCurrentUser();

?>

<aside class="sidebar-right">
    <div>
        <h3>puntos</h3>
        <div class="flex-container-column">
            <p class="points"><?php echo $GLOBALS['session']->getCurrentUser()->getPoints() ?></p>
            <a class="button-blue" href="/ranking.php">Ver ranking</a>
        </div>
       
    </div>
    <div>
        <h3>seguidos</h3>
        <ul>
            <?php foreach (UserRepository::getFollowingInfo($user) as $following): ?>
                <li><a href="/user.php?user=<?php echo $following->getId(); ?>" class="flex-container"><img src="../img/user-default-image.svg" alt="user_img" class="author-icon"> <?php echo $following->getUsername(); ?></a></li>
            <?php endforeach; ?>
        </ul>
    </div>
    <div>
        <h3>seguidores</h3>
        <ul>
            <?php foreach (UserRepository::getFollowersInfo($user) as $follower): ?>
                <li><a href="/user.php?user=<?php echo $follower->getId(); ?>" class="flex-container"><img src="../img/user-default-image.svg" alt="user_img" class="author-icon"> <?php echo $follower->getUsername(); ?></a></li>
            <?php endforeach; ?>
        </ul>
    </div>
</aside>