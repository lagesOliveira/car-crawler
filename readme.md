# Cars Crawler (seminovosbh.com.br)

## Sumary

### Backend Challenge for Job at Alpes One

## Table of contents

- [The Challenge](#the-challenge)
	- [Backend Test](#Backend-Test)
	- [Task](#task)
- [Setup](#setup)
- [Using the API](#Using-the-API)
	- [Understand the results](#Understand-the-results)
	- [Listing 'DESTAQUES' from initial page](#Get-'DESTAQUES'-from-initial-page)
	- [Listing Cars and Order Results](#Get-cars-lists)
	- [Search with parameters](#search-with-parameters)

# The Challenge

## Backend Test
The objective of this test is to assess your level of knowledge in the technologies and tools we will be using. You will need to implement a solution for a common use case in our software.

The test can be completed in many different ways and levels of detail. Try not to limit yourself and use as many tools, modules and tricks as you can. Also, pay attention to the quality and clarity of your code and the extensibility of your proposed solution. The design and architecture are mostly open, so you will have to make sensible decisions about it. These are the things that will make you stand out from the crowd.

The code should be open-sourced in a public repository as the origin of the data used is also public. If you choose to make it private, please provide the necessary credentials to access it.

## Task
The website seminovosbh.com.br is a local portal to search used cars. We need that stock of cars in our services. To do so, you gone crawl the website.

Using PHP, you must provide a RESTful endpoint to search the crawled cars (according the existing filters in the website. No need to be all of them, just the main ones) and another endpoint to view the details of a selected car.

Also, you should give to us all the info about how to run and test your API. Tip: A documentation of your API will be very welcome.

Good look!


# Setup

 ## 1. Cone the repo


```shell
$ git clone https://github.com/lagesOliveira/cars-crawler.git
```

## 2. Install dependencies

```shell
$ composer install
```


# Using the API

## Understand the results

The requests results are provides with Microdata encoding markup available from http://schema.org/Car

Fell free to test in 
https://julio.lagesoliveira.com.br/alpesone/api/

## Get 'DESTAQUES' from initial page

Random list of 10  announced cars 
```
> https://YOUR-DOMAIN/api/getDestaques
```

## Get cars lists

List announced cars

if not pass parameters, default is:

* Order By: 2 (Maior Relevância)
* Items per page: 20


### Order Results
You can order results by:
	
- 2 - Maior Relevância
- 3 - Maior Preço
- 4 - Menor Preço
- 5 - Mais Novo
- 6 - Mais Antigo
		
		
You can show 20, 30 40 or 50 items per page.
		
Usage example:

```
> https://YOUR-DOMAIN/api/getCars/ORDER/QUANTITY

> https://YOUR-DOMAIN/api/getCars/4/30
```

## Get car by productID or SKU

List all details from annoucement.

You need pass productID


```
> https://YOUR-DOMAIN/api/getByCode/PRODUCT_ID

> https://YOUR-DOMAIN/api/getByCode/2636314
```

This is a ferrari F430 (ID: 2636314)

## Search with parameters

The website provide a lot of filter types in sidebar, also here we can use a lot of them  

All parameters are optional

Search by **Brand** and **Model**

Usage example:

```
# Brand
> https://YOUR-DOMAIN/api/searchBy/mitsubishi
> https://YOUR-DOMAIN/api/searchBy/chevrolet

# Model
> https://YOUR-DOMAIN/api/searchBy/chevrolet/prisma
> https://YOUR-DOMAIN/api/searchBy/prisma

```
Search by **YEAR** range

```
# Year Initial
> https://YOUR-DOMAIN/api/searchBy/ano-2016

# Year range
> https://YOUR-DOMAIN/api/searchBy/ano-2015-2016

# Combined with BRAND and MODEL
> https://YOUR-DOMAIN/api/searchBy/chevrolet/prisma/ano-2015
> https://YOUR-DOMAIN/api/searchBy/chevrolet/prisma/ano-2015-2016

```

Search by **PRICE** range min and max
```
# PRICE range R$ 20.000,00 to R$ 25.000,00
> https://YOUR-DOMAIN/api/searchBy/preco-20000-25000

# YEAR and PRICE range
> https://YOUR-DOMAIN/api/searchBy/ano-2015-2016/preco-20000-25000

# Brand, Model, Year and PRICE rage
> https://YOUR-DOMAIN/api/searchBy/chevrolet/prisma/ano-2015-2016/preco-20000-25000

```

Search by **Km Used** (mileageFromOdometer) *Min* and *Max*

```
# Minimum KM Used
> https://YOUR-DOMAIN/api/searchBy/km-1000

# Minimum KM Used and Maximum
> https://YOUR-DOMAIN/api/searchBy/km-1000-2000

# YEAR and PRICE range
> https://YOUR-DOMAIN/api/searchBy/ano-2015-2016/preco-20000-25000/km-5000-20000

# Brand, Model, Year and PRICE rage
> https://YOUR-DOMAIN/api/searchBy/fiat/palio/ano-2015-2016/preco-20000-25000/km-5000-20000

```

You can use too

- **estado-novo** or **estado-seminovo**
- **origem-revenda** or **origem-particular**

Usage example:

```
> https://YOUR-DOMAIN/api/searchBy/estado-novo/origem-particular

> https://YOUR-DOMAIN/api/searchBy/estado-seminovo/origem-revenda

# Combined filters
> https://YOUR-DOMAIN/api/searchBy/fiat/palio/ano-2015-2016/preco-20000-25000/km-5000-20000/estado-seminovo/origem-revenda

```

## Thanks

That's it!

## Copyright and license

Code and documentation copyright 2020 the authors. Code released under the [MIT License](https://reponame/blob/master/LICENSE).

Enjoy :metal:
