# DDD Algorithms


_This project implements algorithms related to Domain-Driven Design (DDD) in PHP. It focuses on providing efficient solutions for various DDD-related challenges, including the Knapsack problem and sequence encryption._

## Project Structure 🏗️

_This project is structured based on the principles of the Hexagonal Architecture and is influenced by the minicli repository. It provides a modular and clean architecture to develop DDD-based applications._

**Note: The project includes an adaptation for integrating a Simple Bus implementation, enhancing its capabilities for command and query handling. CQRS**

- **bin**: Contains executable scripts.
  - **initcli**: Script to initialize the command-line interface.

- **src**: Contains the project's source code.
  - **App.php**: Main class managing the application's logic.

## Code Structure

The `App.php` file contains the main logic of the application. Here, commands are managed, controllers are registered, and corresponding actions are executed.

## Implemented Algorithms 🧠

1. **Knapsack Problem:** The project provides an efficient solution for the classic Knapsack problem, solving optimization challenges related to packing a knapsack with a set of items, each with a weight and a value, to get the maximum value without exceeding the knapsack's capacity.

2. **Sequence Encryption:** The project includes algorithms for encrypting (CRC32) sequences of data, ensuring secure data transmission and storage.

## Simple Bus Integration 🚌

_This project integrates Simple Bus for handling commands and queries. It provides a streamlined approach for implementing CQRS (Command Query Responsibility Segregation) in your DDD-based applications._

## Prerequisites 📋
* [PHP](https://www.php.net/downloads) 
* [Composer](https://golang.org/doc/install)


## Getting Started 🚀
_These instructions will get you a copy of the project up and running on your local machine for development and testing purposes._

```bash
composer install
```

## Running the tests ⚙️



## Usage

To execute commands, use the `initcli` script located in the `bin` directory. Below is a basic example of how to use it:

```bash
./bin/initcli help
```

### Initialize the CLI

_For running the CLI commands, use:_

```bash
./bin/initcli chocobilly orderprocessingcommand --user=name
./bin/initcli chocobos dnaprocessingcommand --user=name
```

## Requirements

- PHP 8.0 or higher
- Composer for dependency management

## Configuration

The project uses a flexible configuration system. You can modify the configuration in the `config/config.php` file to adapt it to your specific needs.
## Getting Started 🚀

## How to Contribute

If you want to contribute to this project, please follow these steps:

1. Fork the repository.
2. Create a branch for your feature: `git checkout -b feature-branch-name`.
3. Make your changes and commit: `git commit -m "Description of changes"`.
4. Push your changes to your fork: `git push origin feature-branch-name`.
5. Create a pull request in this repository.

## License 📄
[![License](http://img.shields.io/:license-mit-blue.svg?style=flat-square)](http://badges.mit-license.org)

- **[MIT license](http://opensource.org/licenses/mit-license.php)**

## Built with 🛠️

- [PHPStorm](https://www.jetbrains.com/phpstorm/) Source-code editor.
## Packages installed
composer require ramsey/uuid
PHPUnit

## Author ✒️
* **Diego Silva** \
[Contact](https://www.linkedin.com/in/diego-silva-r/) 

Copyright 2023 © 

