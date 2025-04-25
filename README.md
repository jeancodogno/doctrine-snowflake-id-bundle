# ❄️ Doctrine Snowflake ID Bundle

Symfony bundle to automatically assign Snowflake-based IDs to your Doctrine entities and documents.
Supports both primary keys and any other custom fields using attributes.

## 🚀 Features

✅ Assigns unique Snowflake IDs to your entities

🔄 Works for both primary keys and custom field using `#[SnowflakeColumn]` or `#[SnowflakeField]`

🧩 Seamlessly integrates with **Doctrine ORM** and **Doctrine ODM**

🧪 Fully testable

## 📦 Installation

Install via Composer:

```bash
composer require jeancodogno/doctrine-snowflake-id-bundle
```
> The bundle uses autoconfiguration, no need to manually register it in `bundles.php`.
## 💡 Usage
> PHP does not have a native type that supports big integers, so the variable must be defined as a `string`.

### 🔐 (Doctrine ORM) Using Snowflake ID Generator
Use the `SnowflakeIdGenerator` class with Doctrine ORM’s custom ID generation:

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

### ✳️ (Doctrine ORM) Assigning Snowflake ID to any column
Use the `#[SnowflakeColumn]` attribute to mark any non-ID field for automatic generation:

```php
use JeanCodogno\DoctrineSnowflakeIdBundle\Attributes\SnowflakeColumn;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class Product
{
    #[ORM\Column(type: 'bigint', unique: true)]
    #[SnowflakeColumn]
    private ?string $publicId = null;

    // ...
}
```
## <img src="https://cdn.jsdelivr.net/gh/devicons/devicon/icons/mongodb/mongodb-original.svg" alt="MongoDB logo" width="24" style="vertical-align: middle;"> (Doctrine ODM) Using Snowflake ID Generator
Use the `MongoSnowflakeIdGenerator` class with Doctrine ODM’s custom ID generation:

```php
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use JeanCodogno\DoctrineSnowflakeIdBundle\IdGenerator\MongoSnowflakeIdGenerator;

#[ODM\Document(collection: 'products')]
class Product
{
    #[ODM\Id(strategy: 'CUSTOM', type: 'string', options: ['class' => MongoSnowflakeIdGenerator::class])]
    private ?string $id;

    // ...
```

## <img src="https://cdn.jsdelivr.net/gh/devicons/devicon/icons/mongodb/mongodb-original.svg" alt="MongoDB logo" width="24" style="vertical-align: middle;"> (Doctrine ODM) Assigning Snowflake ID to any field
use the `#[SnowflakeColumn]` attribute to marky any field for automatic generation:

```php
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use JeanCodogno\DoctrineSnowflakeIdBundle\Attributes\SnowflakeField;

#[ODM\Document(collection: 'products')]
class Product
{
    #[SnowflakeField]
    private ?string $public_id = null;
    
    // ...
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
