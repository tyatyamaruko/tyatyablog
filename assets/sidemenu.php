<input type="checkbox" id="menu">
<label class="sp-menu sp" for="menu">
    <span></span>
    <span></span>
    <span></span>
</label>

<label for="menu" class="back"></label>

<nav>
    <ul class="menu">
        <li><a href="./list.php?type=1&genre=all">技術記事</a></li>
        <li><a href="./list.php?type=0">日常記事</a></li>
    </ul>

    <ul class="topic">
        <li>
            <h5>最新記事</h5>
        </li>
        <?php foreach ($articles as $item) : ?>
            <li>
                <a href="./article.php?id=<?= $item->id ?>">
                    <p class="title"><?= $item->title ?></p>
                    <p class="date"><?= $item->created_at ?></p>
                </a>
            </li>
        <?php endforeach; ?>
    </ul>
</nav>