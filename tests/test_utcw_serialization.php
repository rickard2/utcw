<?php

class test_utcw_serialization extends WP_UnitTestCase
{
    /**
     * @var MockFactory
     */
    private $mockFactory;

    /**
     * @var UTCW_Plugin
     */
    private $plugin;

    function setUp()
    {
        $this->mockFactory = new MockFactory($this);
        $this->plugin      = $this->mockFactory->getUTCWAuthenticated();
    }

    protected function check_serialization($object)
    {
        $serialized = serialize($object);
        $this->assertNotEmpty($serialized, 'is serializable');
        $this->assertNotContains('UTCW_Plugin', $serialized, 'should not serialize plugin instance');
    }

    public function test_selection_strategy_serialization()
    {
        $strategy = new UTCW_SelectionStrategy($this->plugin);
        $this->check_serialization($strategy);
    }

    public function test_render_config_serialization()
    {

        $config = new UTCW_RenderConfig(array(), $this->plugin);

        $this->check_serialization($config);
    }

    public function test_data_config_serialization()
    {
        $config = new UTCW_DataConfig(array(), $this->plugin);

        $this->check_serialization($config);
    }

    public function test_data_serialization()
    {
        $data = new UTCW_Data($this->plugin);

        $this->check_serialization($data);
    }

    public function test_shortcode_serialization()
    {
        $shortCode = new UTCW_ShortCode($this->plugin);

        $this->check_serialization($shortCode);
    }

    public function test_style_provider_serialization()
    {
        $styleProvider = new UTCW_MainStyleProvider($this->plugin);

        $this->check_serialization($styleProvider);
    }
}