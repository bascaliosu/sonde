<?php

// This file has been auto-generated by the Symfony Dependency Injection Component for internal use.

if (\class_exists(\Container95jbv4w\appDevDebugProjectContainer::class, false)) {
    // no-op
} elseif (!include __DIR__.'/Container95jbv4w/appDevDebugProjectContainer.php') {
    touch(__DIR__.'/Container95jbv4w.legacy');

    return;
}

if (!\class_exists(appDevDebugProjectContainer::class, false)) {
    \class_alias(\Container95jbv4w\appDevDebugProjectContainer::class, appDevDebugProjectContainer::class, false);
}

return new \Container95jbv4w\appDevDebugProjectContainer([
    'container.build_hash' => '95jbv4w',
    'container.build_id' => '2972ccb5',
    'container.build_time' => 1562846763,
], __DIR__.\DIRECTORY_SEPARATOR.'Container95jbv4w');
