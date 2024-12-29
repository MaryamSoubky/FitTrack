<?php
use PHPUnit\Framework\TestCase;

class SubscriptionModelTest extends TestCase
{
    private $db;

    protected function setUp(): void
    {
        // Set up an in-memory SQLite database for testing
        $this->db = new PDO('sqlite::memory:');
        $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Create a mock subscriptions table
        $this->db->exec("CREATE TABLE subscriptions (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            user_id INTEGER NOT NULL,
            subscription_plan TEXT NOT NULL,
            start_date TEXT NOT NULL,
            end_date TEXT NOT NULL
        )");
    }

    public function testAddSubscription()
    {
        // Mock database connection in Subscription_Model
        $model = new class($this->db) extends Subscription_Model {
            public function __construct($db)
            {
                $this->db = $db;
            }
        };

        // Call the addSubscription method
        $user_id = 1;
        $subscription_plan = "Premium Plan";
        $start_date = "2024-01-01";
        $end_date = "2024-12-31";

        ob_start();
        $model->addSubscription($user_id, $subscription_plan, $start_date, $end_date);
        $output = ob_get_clean();

        // Verify the output
        $this->assertStringContainsString("Subscription added successfully!", $output);

        // Verify the data in the database
        $stmt = $this->db->query("SELECT * FROM subscriptions WHERE user_id = $user_id");
        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->assertNotEmpty($data, "Subscription should exist in the database.");
        $this->assertEquals($user_id, $data['user_id']);
        $this->assertEquals($subscription_plan, $data['subscription_plan']);
        $this->assertEquals($start_date, $data['start_date']);
        $this->assertEquals($end_date, $data['end_date']);
    }

    public function testAddSubscriptionWithMissingData()
    {
        // Mock database connection in Subscription_Model
        $model = new class($this->db) extends Subscription_Model {
            public function __construct($db)
            {
                $this->db = $db;
            }
        };

        // Call the addSubscription method with missing parameters
        $user_id = 1;
        $subscription_plan = null;
        $start_date = "2024-01-01";
        $end_date = "2024-12-31";

        ob_start();
        $model->addSubscription($user_id, $subscription_plan, $start_date, $end_date);
        $output = ob_get_clean();

        // Verify the output indicates a failure
        $this->assertStringContainsString("Failed to add subscription.", $output);

        // Verify the data was not added to the database
        $stmt = $this->db->query("SELECT * FROM subscriptions WHERE user_id = $user_id");
        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->assertFalse($data, "Subscription should not exist in the database.");
    }
}
