<?php
declare(strict_types=1);

namespace KiwiSuite\Translation;

/** @var PipeConfigurator $pipe */
use KiwiSuite\Admin\Config\AdminConfig;
use KiwiSuite\ApplicationHttp\Pipe\GroupPipeConfigurator;
use KiwiSuite\ApplicationHttp\Pipe\PipeConfigurator;
use KiwiSuite\Translation\Action\CatalogueIndexAction;
use KiwiSuite\Translation\Action\DetailAction;
use KiwiSuite\Translation\Action\IndexAction;
use KiwiSuite\Translation\Action\SaveAction;

$pipe->segmentPipe(AdminConfig::class)(function(PipeConfigurator $pipe) {
    $pipe->segment('/api')( function(PipeConfigurator $pipe) {
        $pipe->group("admin.authorized")(function (GroupPipeConfigurator $group) {
            $group->get('/translation/catalogue', CatalogueIndexAction::class, 'admin.api.translation.catalogue');
            $group->get('/translation/catalogue/{catalogue}', IndexAction::class, 'admin.api.translation.index');
            $group->get('/translation/detail/{id}', DetailAction::class, 'admin.api.translation.detail');
            $group->post('/translation', SaveAction::class, 'admin.api.translation.save');
        });
    });
});


