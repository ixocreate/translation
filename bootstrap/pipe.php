<?php
/**
 * @link https://github.com/ixocreate
 * @copyright IXOCREATE GmbH
 * @license MIT License
 */

declare(strict_types=1);

namespace Ixocreate\Translation\Package;

use Ixocreate\Admin\Package\Config\AdminConfig;
use Ixocreate\Application\Http\Pipe\GroupPipeConfigurator;
use Ixocreate\Application\Http\Pipe\PipeConfigurator;
use Ixocreate\Translation\Package\Action\CatalogueIndexAction;
use Ixocreate\Translation\Package\Action\DetailAction;
use Ixocreate\Translation\Package\Action\IndexAction;
use Ixocreate\Translation\Package\Action\SaveAction;

/** @var PipeConfigurator $pipe */

$pipe->segmentPipe(AdminConfig::class)(function (PipeConfigurator $pipe) {
    $pipe->segment('/api')(function (PipeConfigurator $pipe) {
        $pipe->group("admin.authorized")(function (GroupPipeConfigurator $group) {
            $group->get('/translation/catalogue', CatalogueIndexAction::class, 'admin.api.translation.catalogue');
            $group->get('/translation/catalogue/{catalogue}', IndexAction::class, 'admin.api.translation.index');
            $group->get('/translation/detail/{id}', DetailAction::class, 'admin.api.translation.detail');
            $group->post('/translation', SaveAction::class, 'admin.api.translation.save');
        });
    });
});
