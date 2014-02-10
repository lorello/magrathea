<?php

namespace Tests\Services;

use Silex\Application;
use Silex\Provider\DoctrineServiceProvider;
use App\Services\NodesService;


class NodesServiceTest extends \PHPUnit_Framework_TestCase
{

    private $nodeService;

    public function setUp()
    {
        $app = new Application();

        require __DIR__ . '/../resources/config/test.php';

        date_default_timezone_set('Europe/Rome');

        //define("ROOT_PATH", __DIR__ . "/..");

        //$app->register(new ServiceControllerServiceProvider());

        $app->register(
            new MongodmServiceProvider(),
            array(
                "mongodm.host"     => $app['mongodb.host'],
                "mongodm.db"       => $app['mongodb.db'],
                "mongodm.username" => $app['mongodb.username'],
                "mongodm.password" => $app['mongodb.password'],
                "mongodm.options"  => $app['mongodb.options']
            )
        );


        $app->register(
            new DoctrineServiceProvider(),
            array(
                "db.options" => array(
                    "driver" => "pdo_sqlite",
                    "memory" => true
                ),
            )
        );
        $this->noteService = new NotesService($app["db"]);

        $stmt = $app["db"]->prepare("CREATE TABLE notes (id INTEGER PRIMARY KEY AUTOINCREMENT,note VARCHAR NOT NULL)");
        $stmt->execute();
    }

    public function testGetAll()
    {
        $data = $this->noteService->getAll();
        $this->assertNotNull($data);
    }

    function testSave()
    {
        $note = array("note" => "arny");
        $data = $this->noteService->save($note);
        $data = $this->noteService->getAll();
        $this->assertEquals(1, count($data));
    }

    function testUpdate()
    {
        $note = array("note" => "arny1");
        $this->noteService->save($note);
        $note = array("note" => "arny2");
        $this->noteService->update(1, $note);
        $data = $this->noteService->getAll();
        $this->assertEquals("arny2", $data[0]["note"]);

    }

    function testDelete()
    {
        $note = array("note" => "arny1");
        $this->noteService->save($note);
        $this->noteService->delete(1);
        $data = $this->noteService->getAll();
        $this->assertEquals(0, count($data));
    }

}
