<?php

// This file has been auto-generated by the Symfony Dependency Injection Component for internal use.

if (\class_exists(\ContainerE7uhbpe\appDevDebugProjectContainer::class, false)) {
    // no-op
} elseif (!include __DIR__.'/ContainerE7uhbpe/appDevDebugProjectContainer.php') {
    touch(__DIR__.'/ContainerE7uhbpe.legacy');

    return;
}

if (!\class_exists(appDevDebugProjectContainer::class, false)) {
    \class_alias(\ContainerE7uhbpe\appDevDebugProjectContainer::class, appDevDebugProjectContainer::class, false);
}

return new \ContainerE7uhbpe\appDevDebugProjectContainer([
    'container.build_hash' => 'E7uhbpe',
    'container.build_id' => '287a14da',
    'container.build_time' => 1562925555,
], __DIR__.\DIRECTORY_SEPARATOR.'ContainerE7uhbpe');
