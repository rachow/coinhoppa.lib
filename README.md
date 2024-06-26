# Coinhoppa.lib 📘

**Coinhoppa** is an experimental project, however as the code base expands, engineering minds begin to ponder on ideas on how to better maintain and separate the business logics
in the platform into more manageable parts. You will hear terms like "**Microservices**" and "**Service Oriented Architecture (SOA)**" in the tech world these days.


Oh, have you heard about "**API Design First**" approach? Yeap API's are hot🌶️ and they are built widely, build APIs that are designed to be flexible and robust.

But building REST (**RE**presentational **S**tate **T**ransfer) API's will involve heavy use of shared modules that trigger some sort of action within the platform. API's must also follow good standards that include the following.

- Good standard HTTP verbs use.
- Good authentication. (API's are Stateless)
- Good security
- Caching / Pagination / HTTP Compression (gzip)

We have not yet touched on the architecture behind the API(s), Queues, Message Bus, Kafka, BI tools, etc.

Oh, have you heard about "**API Design First**" approach, yeap API's are hot🌶️ and they are built widely. But building REST APIs will involve heavy use of shared modules and files that trigger some
sort of action.

Meet 👋 this one approach, a repo that holds a lot of the core platform processes through a unified structure, making the codebase more manageable and scalable. 


## Installation

Before installation, ask yourself whether these modules and files are required by your Application/SDK/API or any other service.
Follow the practices below.
 - Your consuming project will make use of the PSR standards to invoke the library modules using the namespace `\\Coinhoppa\\`.
 - Your project does not and will not conflict with the above namespace.
 - You may create symbolic links to map the namespace to a different location within your path structure.

## Global Coinhoppa Commands (GCC)

GCC are CLI (Command Line Interface) commands which are available to the platform through this package or library. These are commands that facilitate scripts or other administration tasks to the platform.

**Note:** There will be a wiki documentation on this topic!

The following are good examples of things that can be tinkered within the platform using GCC.

- Exchange platforms (Health, Tickers, Streams `wss://` , etc)
  - Shutdown, deactivate.
  - More ...
- Coins (Trading pairs, Coin details/history/links/docs etc)
- Kline Service
  - TCP connection to `://kline.xxx:8089`
  - Get OHLCV for a trading pair
  - Restart service / Reload Cached data
  - Pump data into NoSQL DB / Time-Series
- Bots (DCA / Arbitrage) interaction and tinkering and more.
- Interact with AI to get predictions and social network vibes.
  - Python and Go scripts that analyse the data.

### Sample Flavour
```
// Coinhoppa\Console\Exchange

#[AsCommand(name: 'exchange:info')]

protected $signature = 'exchange:info {id: id or UUID of the exchange} {--inactive=0} {--d|deleted=0}';

```
### Why?

There are operations that will still need to be performed through the command line, some scripts may need to scheduled, some process may need to be killed or restarted, etc. These are command and the bells and whistles that happen behind the scenes.

Since a lot of the business processes and components are controlled through the shared package, we will then register and provide access to commands that other Apps and APIs can consume.

There are ideas still floating around and solely depends on the changes to the entire architecture of the platform.

- CNTL Queues / Processes / Threads
- CPU / Memory Checks (This will be node/EC2 [x] dependent and thus, SSH remote scripts execution will be needed)
- Message Bus / Queue
- Tinkering the platform / Authorization / Policies

... TBC
=======
 - Your project does and will not conflict with the above namespace.
 - You may create symbolic links to map the namespace to a different location within your path structure.

TBC.
