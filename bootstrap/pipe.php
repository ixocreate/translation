<?php
declare(strict_types=1);

namespace Ixocreate\Translation;

/** @var PipeConfigurator $pipe */
use Ixocreate\Admin\Config\AdminConfig;
use Ixocreate\ApplicationHttp\Pipe\GroupPipeConfigurator;
use Ixocreate\ApplicationHttp\Pipe\PipeConfigurator;
use Ixocreate\Translation\Action\CatalogueIndexAction;
use Ixocreate\Translation\Action\DetailAction;
use Ixocreate\Translation\Action\IndexAction;
use Ixocreate\Translation\Action\SaveAction;

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


