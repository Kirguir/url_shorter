<div class="row col-sm-6">
    <table class="table table-bordered">
        <thead>
        <tr>
            <td>IP</td>
            <td>Time</td>
            <td>Country</td>
            <td>Browser</td>
            <td>Version</td>
            <td>OS</td>
        </tr>
        </thead>
        <tbody>
        <?php /** @var \App\Model\LinkView[] $views */
        foreach ($views as $view): ?>
            <tr>
                <td><?= $view->getIp() ?></td>
                <td><?= $view->getViewedAt() ?></td>
                <td><?= $view->getCountry() ?></td>
                <td><?= $view->getBrowser() ?></td>
                <td><?= $view->getVersion() ?></td>
                <td><?= $view->getOs() ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
