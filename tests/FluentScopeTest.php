<?php

use LucaDegasperi\OAuth2Server\Repositories\FluentScope;
use Mockery as m;

class FluentScopeTest extends DBTestCase
{
    public function getScopeRepository()
    {
        $server = m::mock('League\OAuth2\Server\AbstractServer');
        $repo = new FluentScope();
        $repo->setServer($server);

        return $repo;
    }

    public function test_get_unexisting_scope()
    {
        $repo = $this->getScopeRepository();
        $repo->limitClientsToScopes(true);
        $repo->limitScopesToGrants(true);

        $result = $repo->get('scope3', 'grant3');

        $this->assertTrue($repo->areClientsLimitedToScopes());
        $this->assertTrue($repo->areScopesLimitedToGrants());
        $this->assertNull($result);
    }

    /*public function test_get_scope_with_grant()
    {
        $repo = $this->getScopeRepository();
        $repo->limitClientsToScopes(true);
        $repo->limitScopesToGrants(true);

        $result = $repo->get('scope1', 'grant1');

        $this->resultAssertions($result); 
    }*/

    /*public function test_get_scope_with_client_only()
    {
        $repo = new FluentScope();
        $repo->limitClientsToScopes(true);

        $result = $repo->get('scope1', 'client1id');

        $this->assertIsScope($result);
    }*/

    public function test_get_scope_with_grant_only()
    {
        $repo = $this->getScopeRepository();
        $repo->limitScopesToGrants(true);

        $result = $repo->get('scope1', 'grant1');

        $this->assertIsScope($result);
    }

    public function test_get_scope()
    {
        $repo = $this->getScopeRepository();
        $result = $repo->get('scope1');  

        $this->assertIsScope($result);
    }

    public function assertIsScope($result)
    {
        $this->assertInstanceOf('League\OAuth2\Server\Entity\Scope', $result);
        $this->assertEquals('scope1', $result->getId());
        $this->assertEquals('Scope 1 Description', $result->getDescription());
    }
}
