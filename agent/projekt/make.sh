libs=lib/bcel.jar:\
lib/GraphLayout.jar:\
lib/jadex_examples.jar:\
lib/jadex_rt.jar:\
lib/jadex_tools.jar:\
lib/janino.jar:\
lib/jhall.jar:\
lib/jibx-bind.jar:\
lib/jibx-extras.jar:\
lib/jibx-run.jar:\
lib/nuggets.jar:\
lib/xmlpull_1_1_4.jar:\
lib/xpp3.jar:\
lib/commons-codec-1.3.jar:\
lib/crimson.jar:\
lib/http.jar:\
lib/iiop.jar:\
lib/jade.jar:\
lib/jadeTools.jar:\
lib/jadex_jadeadapter.jar

if [ "$1" == "jcc" ]
then
  java -cp .:bin:$libs jadex.adapter.jade.tools.Starter
else
  if [ "$1" == "1" ]
  then
    java -cp .:bin:$libs jadex.adapter.jade.tools.Starter -nogui \
    auction_site:mdettla.jadex.pennyauctions.seller.AuctionSite\(20\) \
    buyer1:jadex.adapter.jade.JadeAgentAdapter\(mdettla.jadex.pennyauctions.buyer.Buyer \
    default money=50000 bid_when_time_left=2 min_bids=4 max_price_proc=70 max_bids_per_auction=150\) \
    buyer2:jadex.adapter.jade.JadeAgentAdapter\(mdettla.jadex.pennyauctions.buyer.Buyer \
    default money=50000 bid_when_time_left=2 min_bids=4 max_price_proc=70 max_bids_per_auction=150\) \
    buyer3:jadex.adapter.jade.JadeAgentAdapter\(mdettla.jadex.pennyauctions.buyer.Buyer \
    default money=50000 bid_when_time_left=4 min_bids=4 max_price_proc=70 max_bids_per_auction=100\) \
    buyer4:jadex.adapter.jade.JadeAgentAdapter\(mdettla.jadex.pennyauctions.buyer.Buyer \
    default money=50000 bid_when_time_left=4 min_bids=4 max_price_proc=70 max_bids_per_auction=100\) \
    buyer5:jadex.adapter.jade.JadeAgentAdapter\(mdettla.jadex.pennyauctions.buyer.Buyer \
    default money=50000 bid_when_time_left=4 min_bids=4 max_price_proc=70 max_bids_per_auction=100\) \
    buyer6:jadex.adapter.jade.JadeAgentAdapter\(mdettla.jadex.pennyauctions.buyer.Buyer \
    default money=50000 bid_when_time_left=4 min_bids=4 max_price_proc=70 max_bids_per_auction=100\)
  else
    if [ $# -eq 0 ]
    then
      if [ ! -d bin ]
      then
        mkdir bin
      fi
      javac -cp $libs -d bin \
      src/mdettla/jadex/pennyauctions/buyer/*.java \
      src/mdettla/jadex/pennyauctions/seller/*.java \
      src/mdettla/jadex/pennyauctions/util/*.java
      cp src/mdettla/jadex/pennyauctions/buyer/*.xml bin/mdettla/jadex/pennyauctions/buyer
    else # test
      java -cp .:bin:$libs jadex.adapter.jade.tools.Starter -nogui \
      auction_site:mdettla.jadex.pennyauctions.seller.AuctionSite\(500\) \
      buyer1:jadex.adapter.jade.JadeAgentAdapter\(mdettla.jadex.pennyauctions.buyer.Buyer \
      default money=10000 max_price_proc=50 bid_when_time_left=3 min_bids=4 max_bids_per_auction=4\) \
      buyer2:jadex.adapter.jade.JadeAgentAdapter\(mdettla.jadex.pennyauctions.buyer.Buyer \
      default money=10000 max_price_proc=50 bid_when_time_left=3 min_bids=4 max_bids_per_auction=4\)
    fi
  fi
fi
