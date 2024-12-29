<?php

use PHPUnit\Framework\TestCase;

class SubscriptionControllerTest extends TestCase
{
    private $subscriptionModelMock;

    protected function setUp(): void
    {
        // Mock the SubscriptionModel
        $this->subscriptionModelMock = $this->createMock(SubscriptionModel::class);
    }

    public function testAddSubscriptionValidPlan()
    {
        // Prepare the mock behavior
        $this->subscriptionModelMock->expects($this->once())
            ->method('insertSubscription')
            ->with(
                $this->equalTo(1), // User ID
                $this->equalTo('1_month'), // Plan
                $this->isType('string'), // Start date
                $this->isType('string')  // End date
            )
            ->willReturn(true);

        // Inject the mock into the controller function
        $result = addSubscription(1, '1_month');
        
        // Assert the expected result
        $this->assertTrue($result);
    }

    public function testAddSubscriptionInvalidPlan()
    {
        // Ensure insertSubscription is never called for invalid plans
        $this->subscriptionModelMock->expects($this->never())
            ->method('insertSubscription');

        // Test with an invalid plan
        $result = addSubscription(1, 'invalid_plan');

        // Assert the expected result
        $this->assertFalse($result);
    }
}
