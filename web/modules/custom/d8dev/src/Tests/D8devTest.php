<?php

namespace Drupal\d8dev\Tests;

use Drupal\simpletest\WebTestBase;

/**
 * Test out d8Dev module functionality.
 *
 * @group d8dev
 */
class D8devTest extends WebTestBase {

  /**
   * Test that the 'mypage/page' path returns the right content.
   */
  public function testCustomPageExists() {
    $this->drupalGet('mypage/page');
    $this->assertResponse(200);
  }

}
