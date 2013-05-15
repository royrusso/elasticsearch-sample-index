ElasticSearch Sample Index Data Script (PHP)
==========================

This sample script reads from the included CSV file and adds 150 'superhero' documents to an index 'comicbook'.

I needed a way to quickly create indexes/shards and fill them with documents for my [ElasticSearch Monitoring solution](https://github.com/royrusso/elasticsearch-HQ, "Elastic HQ").

Usage
--------

* Create the Index:

```
curl -XPUT 'http://localhost:9200/comicbook/' -d '{
    "settings" : {
        "index" : {
            "number_of_shards" : 3,
            "number_of_replicas" : 1
        }
    }
}'
```

* From command line, execute the script:

```
php elasticput.php
```

* Script should output:

```
...
INDEXING ROW: 15 HERO: Punisher
RESPONSE: {"ok":true,"_index":"comicbook","_type":"superhero","_id":"14","_version":1}

INDEXING ROW: 16 HERO: Flash
RESPONSE: {"ok":true,"_index":"comicbook","_type":"superhero","_id":"15","_version":1}

INDEXING ROW: 17 HERO: Magneto
RESPONSE: {"ok":true,"_index":"comicbook","_type":"superhero","_id":"16","_version":1}
...
```

* Once complete, perform a search:

```
http://localhost:9200/comicbook/superhero/_search?q=summary:Kent

hits: {
  total: 6,
  max_score: 0.71193624,
  hits: [
  {
    _index: "comicbook",
    _type: "superhero",
    _id: "89",
    _score: 0.71193624,
    _source: {
      name: "Clark Kent",
      summary: "Clark Kent is an American fictional character created by Jerry Siegel and Joe Shuster. ..."
  }
},
```
