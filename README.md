## Introduction

An extension of the aranyasen/hl7 build specifically modified for ORM^001 messages. This package solidifies 
the relationship between OBX and OBR segments by giving them a concrete parent/child relationship.
 
## Installation

```bash
composer require nstaff/hl7-oru
```

## Usage
### Parsing
See aranyasen/hl7 for basic usage details

### Using obx - obr relationship
```php
    //With a new message instantiated
    $obrArray = $msg->getOBRs();
    $obxs = $obrArray[0]->getOBXs();
```
Fields can be accessed using aranyasen library. However some additions were made/overridden

```php
    //Gives the type of the segment. OBX.3
    $obxs[0]->getType();
    //Gives the value of the segment OBX.5
    $obxs[0]->getValue();
```

Child OBXs are can be assigned at runtime
```
    $obrArray[0]->addOBX($myObxVar);
```

For convenience, plain language getters setters for ordering provider have been added to the OBR segments to do nested
array access on first and last name. Typically:
```
    $obr->getOrderingProvider();
```
will return an array. To make life simpler this wrapper was also added to provide direct access to first and last names:
```
    $obr->getOrderingProviderFirst();
    $obr->getOrderingProviderLast();
```

Additionally retriving test code and plan language test name for the OBR were added:
```
    $obr->getTestCode();
    $obr->getTestName();
```

### TODOs
* Data Validation
* Search by regex and return segment/field/index
* Define more segments
