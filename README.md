# ❄️ Doctrine Snowflake ID Bundle

Symfony bundle to automatically assign Snowflake-based IDs to your Doctrine entities.
Supports both primary keys and any other custom fields using attributes.

## 🚀 Features

✅ Assigns unique Snowflake IDs to your entities

🔄 Works for both primary keys and custom fields

🧩 Seamlessly integrates with Doctrine ORM

🧪 Fully testable

## 📦 Installation

Install via Composer:

```bash
composer require jeancodogno/doctrine-snowflake-id-bundle
```
> The bundle uses autoconfiguration, no need to manually register it in `bundles.php`.
## 💡 Usage

### 🔐 Option 1: Using Snowflake ID as Primary Key
Use the `SnowflakeIdGenerator` class with Doctrine’s custom ID generation:

```php
use JeanCodogno\DoctrineSnowflakeIdBundle\SnowflakeIdGenerator;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class Product
{
    #[ORM\Id]
    #[ORM\Column(type: 'bigint')]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: SnowflakeIdGenerator::class)]
    private ?string $id = null;

    // ...
}
```

### ✳️ Option 2: Assigning Snowflake ID to Custom Fields
Use the `#[AutoSnowflake]` attribute to mark any non-ID field for automatic generation:

```php
use JeanCodogno\DoctrineSnowflakeIdBundle\Attributes\AutoSnowflake;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class Product
{
    #[ORM\Column(type: 'bigint', unique: true)]
    #[AutoSnowflake]
    private ?string $publicId = null;

    // ...
}
```


## 🔧 Configuration
By default, `DoctrineSnowflakeIdBundle` works without any configuration, using default values for `datacenterId`, `workerId`, and `startTimestamp`.

If you want to customize these values, you can define the following parameters in your Symfony configuration:

```yaml 
#config/services.yaml

parameters:
    snowflake_id.datacenter_id: 2         # Default: 0
    snowflake_id.worker_id: 7             # Default: 0
    snowflake_id.start_timestamp: 1672531200000  # Optional – e.g., Jan 1, 2023 in milliseconds
```
## 🧪 Testing
You can test ID assignment with tools like PHPUnit or Pest. Snowflake IDs are generated before persist, ensuring uniqueness without collisions.

## 📜 License
This bundle is open-source software licensed under the [MIT license](https://choosealicense.com/licenses/mit/)
