<p align="center"><img src="https://laravel.com/assets/img/components/logo-laravel.svg"></p>

### 首页接口

- 当前日期 ( http://45.157.91.155/NowDate )


    2020年08月10日
- **快速导航** ( http://45.157.91.155/FastNavigation )
    
    
    
    
        {
            "id": 1,
            "game": "DOTA2",
            "gameimg": "https:\/\/500bf.com\/static\/index\/img\/dota_sel_icon.png",
            "created_at": null,
            "updated_at": null
        },
        {
            "id": 2,
            ...
        },
        {
            "id": 3,
            ...
        },
        {
            "id": 4,
            "game": "\u738b\u8005\u8363\u8000",
            "gameimg": "https:\/\/500bf.com\/static\/index\/img\/kog_sel_icon.png",
            "created_at": null,
            "updated_at": null
        }
    


- 游戏赛事导航 ( http://45.157.91.155/GameNavigation )


    
        "DOTA2": [
            {
                "id": 270,
                "match": "ESL One\u6cf0\u56fd 2020-\u9884\u9009\u8d5b",
                "matchimg": "https:\/\/qn.feijing88.com\/egame\/dota\/league\/e48ed7e98bad3235b79a2a1648ea60a2.png"
            },
            {
                "id": 269,
                "match": "OMEGA League \u9884\u9009\u8d5b",
                "matchimg": "https:\/\/qn.feijing88.com\/egame\/dota\/league\/547fc21588b1b132a1da55b3c46f693e.png"
            },
            {
                "id": 268,
                "match": "Moon Studio\u4e9a\u6d32\u8054\u8d5b",
                "matchimg": "https:\/\/qn.feijing88.com\/egame\/dota\/league\/9e993fa9bc2034a5ba11cd230700ceeb.png"
            },
            {
                "id": 267,
                "match": "DOTA\u590f\u5b63\u8054\u8d5b \u7b2c\u4e00\u5b63",
                "matchimg": "https:\/\/qn.feijing88.com\/egame\/dota\/league\/a875db9e2bc0bd2e5720d8ae0155ff1c.png"
            }
        ],
        
        "CS:GO": [
           ...
        ],
        
        "\u82f1\u96c4\u8054\u76df": [
            ...
        ],
        
        "\u738b\u8005\u8363\u8000": [
            {
                "id": 250,
                "match": "2020\u738b\u8005\u51a0\u519b\u676f",
                "matchimg": "https:\/\/qn.feijing88.com\/egame\/kog\/league\/9baacc448e77003ed6b32ae66139f630.png"
            },
            {
                "id": 242,
                "match": "2020 \u738b\u8005\u51a0\u519b\u676f",
                "matchimg": "https:\/\/qn.feijing88.com\/egame\/kog\/league\/9baacc448e77003ed6b32ae66139f630.png"
            },
            {
                "id": 193,
                "match": "2020\u4e16\u754c\u51a0\u519b\u676f",
                "matchimg": "https:\/\/qn.feijing88.com\/egame\/kog\/league\/9baacc448e77003ed6b32ae66139f630.png"
            },
            {
                "id": 5,
                "match": "2020 KPL\u6625\u5b63\u8d5b",
                "matchimg": "https:\/\/qn.feijing88.com\/egame\/kog\/league\/3767c1e22299befd683350035b98ad62.png"
            }
        ]
    

- 首页全部游戏正在进行 ( http://45.157.91.155/GetAllMatchIng )

    
    [
        {
            "id": 1,
            "eventsimg": "https:\/\/qn.feijing88.com\/feijing-home\/egame\/image\/2020612\/f22fd95faa0648aca48e3348fc3ccc60.png",
            "events": "2020 LDL\u590f\u5b63\u8d5b",
            "game": "\u82f1\u96c4\u8054\u76df",
            "eventsid": 139,
            "tv": [
                "\u864e\u7259356",
                "\u6597\u9c7c244",
                "\u6597\u9c7c194",
                "\u864e\u7259821",
                "\u864e\u72592077"
            ],
            "now": "\u7b2c\u4e00\u5c400",
            "BO": "BO3",
            "pooreconomy": "0K",
            "team1img": "https:\/\/qn.feijing88.com\/feijing-home\/egame\/image\/202083\/c3feb03d14124449ab7d3e227601c2fc.png",
            "team1": "OMD",
            "team1winnum": 0,
            "team1killnum": 0,
            "team1special": "",
            "team2img": "https:\/\/qn.feijing88.com\/feijing-home\/egame\/image\/20190920\/365503c142524f51965a3adb9a2a6c7d.png",
            "team2": "LNG.A",
            "team2winnum": 0,
            "team2killnum": 0,
            "team2special": "",
            "created_at": null,
            "updated_at": null
        },
        ... . ..
        {
            "id": 7,
            "eventsimg": "https:\/\/qn.feijing88.com\/egame\/csgo\/league\/6cb32166930104d7c043ca5f470ce21a.png",
            "events": "Nine to Five 3 Dawn",
            "game": "CS:GO",
            "eventsid": 293,
            "tv": "",
            "now": "MIRAGER:26",
            "BO": "BO3",
            "pooreconomy": "0K",
            "team1img": "https:\/\/qn.feijing88.com\/feijing-home\/egame\/image\/csgo\/team.png",
            "team1": "Tikitakan",
            "team1winnum": 0,
            "team1killnum": 0,
            "team1special": "https:\/\/www.500bf.com\/static\/index\/img\/cs_firstkill.png|https:\/\/www.500bf.com\/static\/index\/img\/cs_mine.png|https:\/\/www.500bf.com\/static\/index\/img\/cs_16kill.png",
            "team2img": "https:\/\/qn.feijing88.com\/feijing-home\/egame\/image\/20190121\/9dab47b972af4930bcfc87e3c62ef507.jpg",
            "team2": "Nexus",
            "team2winnum": 1,
            "team2killnum": 0,
            "team2special": "",
            "created_at": null,
            "updated_at": null
        }
    ]


- 首页指定游戏正在进行 ( http://45.157.91.155/AppointMatchIng/$id ) 


    [
        {
            "id": 1,
            "eventsimg": "https:\/\/qn.feijing88.com\/feijing-home\/egame\/image\/2020612\/f22fd95faa0648aca48e3348fc3ccc60.png",
            "events": "2020 LDL\u590f\u5b63\u8d5b",
            "game": "\u82f1\u96c4\u8054\u76df",
            "eventsid": 139,
            "tv": [
                "\u864e\u7259356",
                "\u6597\u9c7c244",
                "\u6597\u9c7c194",
                "\u864e\u7259821",
                "\u864e\u72592077"
            ],
            "now": "\u7b2c\u4e00\u5c400",
            "BO": "BO3",
            "pooreconomy": "0K",
            "team1img": "https:\/\/qn.feijing88.com\/feijing-home\/egame\/image\/202083\/c3feb03d14124449ab7d3e227601c2fc.png",
            "team1": "OMD",
            "team1winnum": 0,
            "team1killnum": 0,
            "team1special": "",
            "team2img": "https:\/\/qn.feijing88.com\/feijing-home\/egame\/image\/20190920\/365503c142524f51965a3adb9a2a6c7d.png",
            "team2": "LNG.A",
            "team2winnum": 0,
            "team2killnum": 0,
            "team2special": "",
            "created_at": null,
            "updated_at": null
        },
        ... ...
        {
            "id": 5,
            "eventsimg": "https:\/\/qn.feijing88.com\/feijing-home\/egame\/image\/2020612\/f22fd95faa0648aca48e3348fc3ccc60.png",
            "events": "2020 LDL\u590f\u5b63\u8d5b",
            "game": "\u82f1\u96c4\u8054\u76df",
            "eventsid": 139,
            "tv": [
                "\u864e\u7259356",
                "\u6597\u9c7c194",
                "\u864e\u72592077",
                "\u864e\u7259899"
            ],
            "now": "\u7b2c\u4e00\u5c400",
            "BO": "BO3",
            "pooreconomy": "0K",
            "team1img": "https:\/\/qn.feijing88.com\/feijing-home\/egame\/image\/20190920\/4a5cd1199d504544abe9513ae2c32493.png",
            "team1": "VTG",
            "team1winnum": 0,
            "team1killnum": 0,
            "team1special": "",
            "team2img": "https:\/\/qn.feijing88.com\/feijing-home\/egame\/image\/20190302\/af20d3e7409b499aa1216eaabcf0ab6c.jpg",
            "team2": "LEG",
            "team2winnum": 0,
            "team2killnum": 0,
            "team2special": "",
            "created_at": null,
            "updated_at": null
        }
    ]


- 首页全部游戏未开始 ( http://45.157.91.155/GetAllMatch )


    [
        {
            "id": 1,
            "gameimg": "https:\/\/www.500bf.com\/static\/index\/img\/lol_sel_icon.png",
            "game": "\u82f1\u96c4\u8054\u76df",
            "time": "16:00",
            "BO": "BO3",
            "team1": "OZ",
            "team1img": "https:\/\/qn.feijing88.com\/feijing-home\/egame\/image\/lol\/team.png",
            "team2img": "https:\/\/qn.feijing88.com\/feijing-home\/egame\/image\/lol\/team.png",
            "team2": "ELM",
            "eventsimg": "https:\/\/qn.feijing88.com\/egame\/lol\/league\/9c7ea58bd9ffe8e5a1602dd166a2a0cc.jpg",
            "events": "2020 CK\u590f\u5b63\u8d5b",
            "eventsid": 175,
            "created_at": null,
            "updated_at": null
        },
        ...
        {
            "id": 20,
            "gameimg": "https:\/\/www.500bf.com\/static\/index\/img\/csgo_sel_icon.png",
            "game": "CS:GO",
            "time": "16:30",
            "BO": "BO3",
            "team1": "Ground Zero",
            "team1img": "https:\/\/qn.feijing88.com\/feijing-home\/egame\/image\/20190121\/584f7d5686124b9285f1f90f061ee1bb.jpg",
            "team2img": "https:\/\/qn.feijing88.com\/egame\/csgo\/team\/35dbd4e5a101fff12c3368615ff040fd.png",
            "team2": "Paradox",
            "eventsimg": "https:\/\/qn.feijing88.com\/egame\/csgo\/league\/9dea94311125f453bdf2855766440667.png",
            "events": "ESL Australia & NZ Championship Season 11",
            "eventsid": 110,
            "created_at": null,
            "updated_at": null
        }
    ]


- 首页指定游戏未开始 ( http://45.157.91.155/AppointMatch/$id )


    [
        {
            "id": 4,
            "gameimg": "https:\/\/www.500bf.com\/static\/index\/img\/csgo_sel_icon.png",
            "game": "CS:GO",
            "time": "17:10",
            "BO": "BO3",
            "team1": "AVANT",
            "team1img": "https:\/\/qn.feijing88.com\/feijing-home\/egame\/image\/20190121\/48b9b58ae0814a97844a62d981bda9f1.jpg",
            "team2img": "https:\/\/qn.feijing88.com\/egame\/csgo\/team\/35dbd4e5a101fff12c3368615ff040fd.png",
            "team2": "Paradox",
            "eventsimg": "https:\/\/qn.feijing88.com\/egame\/csgo\/league\/038803234a89e88bdcf7388fc19eb0cd.png",
            "events": "ESEA MDL Season 34 Australia",
            "eventsid": 55,
            "created_at": null,
            "updated_at": null
        },
        ... ...
        {
            "id": 20,
            "gameimg": "https:\/\/www.500bf.com\/static\/index\/img\/csgo_sel_icon.png",
            "game": "CS:GO",
            "time": "16:30",
            "BO": "BO3",
            "team1": "Ground Zero",
            "team1img": "https:\/\/qn.feijing88.com\/feijing-home\/egame\/image\/20190121\/584f7d5686124b9285f1f90f061ee1bb.jpg",
            "team2img": "https:\/\/qn.feijing88.com\/egame\/csgo\/team\/35dbd4e5a101fff12c3368615ff040fd.png",
            "team2": "Paradox",
            "eventsimg": "https:\/\/qn.feijing88.com\/egame\/csgo\/league\/9dea94311125f453bdf2855766440667.png",
            "events": "ESL Australia & NZ Championship Season 11",
            "eventsid": 110,
            "created_at": null,
            "updated_at": null
        }
    ]


- 首页右侧刚刚结束 ( http://45.157.91.155/JustOver )


    [
        {
            "gameimg": "https:\/\/www.500bf.com\/static\/index\/img\/lol_sel_icon.png",
            "team1": "CLG",
            "score": "0-2",
            "team2": "DIG",
            "time": "08:03"
        },
        ... ...
        {
            "gameimg": "https:\/\/www.500bf.com\/static\/index\/img\/csgo_sel_icon.png",
            "team1": "Chaos",
            "score": "0-2",
            "team2": "New England Whalers",
            "time": "04:55"
        }
    ]



### 比分页接口

- 全部游戏正在进行 ( http://45.157.91.155/GetScoreIng )


    [
        {
            "id": 1,
            "gameimg": "https:\/\/www.500bf.com\/static\/index\/img\/csgo_sel_icon.png",
            "game": "CS:GO",
            "events": "Nine to Five 3 Dawn",
            "eventsid": "293",
            "tag": "BO3",
            "tag1": "\u9635\u5bb9",
            "tag2": "\u672c\u5c40 ",
            "tag3": "\u4e0a\u534a\u573a ",
            "tag4": "\u4e0b\u534a\u573a ",
            "tag5": "\u52a0\u65f6 ",
            "tag6": "",
            "index": "\u6307\u6570",
            "tv": [
                "\u864e\u7259356",
                "\u6597\u9c7c244",
                "\u6597\u9c7c194",
                "\u864e\u7259821",
                "\u864e\u72592077"
            ],
            "now": "",
            "nowtime": "R:",
            "team1img": "https:\/\/qn.feijing88.com\/feijing-home\/egame\/image\/csgo\/team.png",
            "team1": "Tenerife Titans",
            "team1winnum": 1,
            "team1lineup": "T",
            "team1killnum": 8,
            "team1killspecial": [
                "https:\/\/www.500bf.com\/static\/index\/img\/cs_firstkill.png",
                "https:\/\/www.500bf.com\/static\/index\/img\/cs_mine.png"
            ],
            "team1tag3num": "8",
            "team1tag3special": [
                "https:\/\/www.500bf.com\/static\/index\/img\/cs_firstkill.png",
                "https:\/\/www.500bf.com\/static\/index\/img\/cs_mine.png"
            ],
            "team1tag4num": "0",
            "team1tag4special": [
                "https:\/\/www.500bf.com\/static\/index\/img\/cs_firstkill.png",
                "https:\/\/www.500bf.com\/static\/index\/img\/cs_mine.png"
            ],
            "team1tag5num": "0",
            "team1tag5special": [
                "https:\/\/www.500bf.com\/static\/index\/img\/cs_firstkill.png",
                "https:\/\/www.500bf.com\/static\/index\/img\/cs_mine.png"
            ],
            "team1tag6num": "1.11K",
            "team1indexnum": "2.73",
            "team2img": "https:\/\/qn.feijing88.com\/feijing-home\/egame\/image\/20190404\/8e65baff92994083a977840de410e65c.jpg",
            "team2": "Apeks",
            "team2winnum": 0,
            "team2lineup": "CT",
            "team2killnum": 10,
            "team2killspecial": [
                "https:\/\/www.500bf.com\/static\/index\/img\/cs_firstkill.png",
                "https:\/\/www.500bf.com\/static\/index\/img\/cs_mine.png"
            ],
            "team2tag3num": "7",
            "team2tag3special": [
                "https:\/\/www.500bf.com\/static\/index\/img\/cs_firstkill.png",
                "https:\/\/www.500bf.com\/static\/index\/img\/cs_mine.png"
            ],
            "team2tag4num": "3",
            "team2tag4special": [
                "https:\/\/www.500bf.com\/static\/index\/img\/cs_firstkill.png",
                "https:\/\/www.500bf.com\/static\/index\/img\/cs_mine.png"
            ],
            "team2tag5num": "0",
            "team2tag5special": [
                "https:\/\/www.500bf.com\/static\/index\/img\/cs_firstkill.png",
                "https:\/\/www.500bf.com\/static\/index\/img\/cs_mine.png"
            ],
            "team2tag6num": "",
            "team2indexnum": "1.42",
            "created_at": null,
            "updated_at": null,
            "pooimg": "http:\/\/qn.gunqiu.com\/pcweb\/drop_icon.png"
        },
         ... ...
        {
            "id": 6,
            "gameimg": "https:\/\/www.500bf.com\/static\/index\/img\/csgo_sel_icon.png",
            "game": "CS:GO",
            "events": "ESL Australia & NZ Championship Season 11",
            "eventsid": "110",
            "tag": "BO3",
            "tag1": "\u9635\u5bb9",
            "tag2": "\u672c\u5c40 ",
            "tag3": "\u4e0a\u534a\u573a ",
            "tag4": "\u4e0b\u534a\u573a ",
            "tag5": "\u52a0\u65f6 ",
            "tag6": "",
            "index": "\u6307\u6570",
            "tv": "",
            "now": "",
            "nowtime": "R:",
            "team1img": "https:\/\/qn.feijing88.com\/egame\/csgo\/team\/35dbd4e5a101fff12c3368615ff040fd.png",
            "team1": "Paradox",
            "team1winnum": 0,
            "team1lineup": "T",
            "team1killnum": 1,
            "team1killspecial": "",
            "team1tag3num": "1",
            "team1tag3special": "",
            "team1tag4num": "0",
            "team1tag4special": "",
            "team1tag5num": "0",
            "team1tag5special": "",
            "team1tag6num": "",
            "team1indexnum": "1.38",
            "team2img": "https:\/\/qn.feijing88.com\/feijing-home\/egame\/image\/csgo\/team.png",
            "team2": "TRUCKERS WITH ATTITUDE",
            "team2winnum": 0,
            "team2lineup": "CT",
            "team2killnum": 0,
            "team2killspecial": "",
            "team2tag3num": "0",
            "team2tag3special": "",
            "team2tag4num": "0",
            "team2tag4special": "",
            "team2tag5num": "0",
            "team2tag5special": "",
            "team2tag6num": "",
            "team2indexnum": "2.94",
            "created_at": null,
            "updated_at": null,
            "pooimg": ""
        }
    ]

- 指定游戏正在进行 ( http://45.157.91.155/AppointScoreIng/$id )


    http://45.157.91.155/AppointScoreIng/2
    [
        {
            "id": 1,
            "gameimg": "https:\/\/www.500bf.com\/static\/index\/img\/csgo_sel_icon.png",
            "game": "CS:GO",
            "events": "Nine to Five 3 Dawn",
            "eventsid": "293",
            "tag": "BO3",
            "tag1": "\u9635\u5bb9",
            "tag2": "\u672c\u5c40 ",
            "tag3": "\u4e0a\u534a\u573a ",
            "tag4": "\u4e0b\u534a\u573a ",
            "tag5": "\u52a0\u65f6 ",
            "tag6": "",
            "index": "\u6307\u6570",
            "tv": [
                "\u864e\u7259356",
                "\u6597\u9c7c244",
                "\u6597\u9c7c194",
                "\u864e\u7259821",
                "\u864e\u72592077"
            ],
            "now": "",
            "nowtime": "R:",
            "team1img": "https:\/\/qn.feijing88.com\/feijing-home\/egame\/image\/csgo\/team.png",
            "team1": "Tenerife Titans",
            "team1winnum": 1,
            "team1lineup": "T",
            "team1killnum": 8,
            "team1killspecial": [
                "https:\/\/www.500bf.com\/static\/index\/img\/cs_firstkill.png",
                "https:\/\/www.500bf.com\/static\/index\/img\/cs_mine.png"
            ],
            "team1tag3num": "8",
            "team1tag3special": [
                "https:\/\/www.500bf.com\/static\/index\/img\/cs_firstkill.png",
                "https:\/\/www.500bf.com\/static\/index\/img\/cs_mine.png"
            ],
            "team1tag4num": "0",
            "team1tag4special": [
                "https:\/\/www.500bf.com\/static\/index\/img\/cs_firstkill.png",
                "https:\/\/www.500bf.com\/static\/index\/img\/cs_mine.png"
            ],
            "team1tag5num": "0",
            "team1tag5special": [
                "https:\/\/www.500bf.com\/static\/index\/img\/cs_firstkill.png",
                "https:\/\/www.500bf.com\/static\/index\/img\/cs_mine.png"
            ],
            "team1tag6num": "1.11K",
            "team1indexnum": "2.73",
            "team2img": "https:\/\/qn.feijing88.com\/feijing-home\/egame\/image\/20190404\/8e65baff92994083a977840de410e65c.jpg",
            "team2": "Apeks",
            "team2winnum": 0,
            "team2lineup": "CT",
            "team2killnum": 10,
            "team2killspecial": [
                "https:\/\/www.500bf.com\/static\/index\/img\/cs_firstkill.png",
                "https:\/\/www.500bf.com\/static\/index\/img\/cs_mine.png"
            ],
            "team2tag3num": "7",
            "team2tag3special": [
                "https:\/\/www.500bf.com\/static\/index\/img\/cs_firstkill.png",
                "https:\/\/www.500bf.com\/static\/index\/img\/cs_mine.png"
            ],
            "team2tag4num": "3",
            "team2tag4special": [
                "https:\/\/www.500bf.com\/static\/index\/img\/cs_firstkill.png",
                "https:\/\/www.500bf.com\/static\/index\/img\/cs_mine.png"
            ],
            "team2tag5num": "0",
            "team2tag5special": [
                "https:\/\/www.500bf.com\/static\/index\/img\/cs_firstkill.png",
                "https:\/\/www.500bf.com\/static\/index\/img\/cs_mine.png"
            ],
            "team2tag6num": "",
            "team2indexnum": "1.42",
            "created_at": null,
            "updated_at": null,
            "pooimg": "http:\/\/qn.gunqiu.com\/pcweb\/drop_icon.png"
        },
        ... ...
        {
            "id": 6,
            "gameimg": "https:\/\/www.500bf.com\/static\/index\/img\/csgo_sel_icon.png",
            "game": "CS:GO",
            "events": "ESL Australia & NZ Championship Season 11",
            "eventsid": "110",
            "tag": "BO3",
            "tag1": "\u9635\u5bb9",
            "tag2": "\u672c\u5c40 ",
            "tag3": "\u4e0a\u534a\u573a ",
            "tag4": "\u4e0b\u534a\u573a ",
            "tag5": "\u52a0\u65f6 ",
            "tag6": "",
            "index": "\u6307\u6570",
            "tv": "",
            "now": "",
            "nowtime": "R:",
            "team1img": "https:\/\/qn.feijing88.com\/egame\/csgo\/team\/35dbd4e5a101fff12c3368615ff040fd.png",
            "team1": "Paradox",
            "team1winnum": 0,
            "team1lineup": "T",
            "team1killnum": 1,
            "team1killspecial": "",
            "team1tag3num": "1",
            "team1tag3special": "",
            "team1tag4num": "0",
            "team1tag4special": "",
            "team1tag5num": "0",
            "team1tag5special": "",
            "team1tag6num": "",
            "team1indexnum": "1.38",
            "team2img": "https:\/\/qn.feijing88.com\/feijing-home\/egame\/image\/csgo\/team.png",
            "team2": "TRUCKERS WITH ATTITUDE",
            "team2winnum": 0,
            "team2lineup": "CT",
            "team2killnum": 0,
            "team2killspecial": "",
            "team2tag3num": "0",
            "team2tag3special": "",
            "team2tag4num": "0",
            "team2tag4special": "",
            "team2tag5num": "0",
            "team2tag5special": "",
            "team2tag6num": "",
            "team2indexnum": "2.94",
            "created_at": null,
            "updated_at": null,
            "pooimg": ""
        }
    ]


- 全部游戏未开始 ( http://45.157.91.155/ScoreNotStarted )


    [
        {
            "id": 1,
            "gameimg": "https:\/\/www.500bf.com\/static\/index\/img\/lol_sel_icon.png",
            "game": "\u82f1\u96c4\u8054\u76df",
            "time": "16:00",
            "BO": "BO3",
            "team1": "OZ",
            "team1img": "https:\/\/qn.feijing88.com\/feijing-home\/egame\/image\/lol\/team.png",
            "team2img": "https:\/\/qn.feijing88.com\/feijing-home\/egame\/image\/lol\/team.png",
            "team2": "ELM",
            "eventsimg": "https:\/\/qn.feijing88.com\/egame\/lol\/league\/9c7ea58bd9ffe8e5a1602dd166a2a0cc.jpg",
            "events": "2020 CK\u590f\u5b63\u8d5b",
            "eventsid": 175,
            "index": "",
            "created_at": null,
            "updated_at": null
        },
         ... ...
        {
            "id": 19,
            "gameimg": "https:\/\/www.500bf.com\/static\/index\/img\/csgo_sel_icon.png",
            "game": "CS:GO",
            "time": "15:00",
            "BO": "BO3",
            "team1": "Tikitakan",
            "team1img": "https:\/\/qn.feijing88.com\/feijing-home\/egame\/image\/csgo\/team.png",
            "team2img": "https:\/\/qn.feijing88.com\/feijing-home\/egame\/image\/20190121\/9dab47b972af4930bcfc87e3c62ef507.jpg",
            "team2": "Nexus",
            "eventsimg": "https:\/\/qn.feijing88.com\/egame\/csgo\/league\/6cb32166930104d7c043ca5f470ce21a.png",
            "events": "Nine to Five 3 Dawn",
            "eventsid": 293,
            "index": "1.45\/2.63",
            "created_at": null,
            "updated_at": null
        }
    ]

- 指定获取游戏未开始 ( http://45.157.91.155/ScoreAppointNotStarted/{id} ) 


    [
        {
            "id": 4,
            "gameimg": "https:\/\/www.500bf.com\/static\/index\/img\/csgo_sel_icon.png",
            "game": "CS:GO",
            "time": "17:10",
            "BO": "BO3",
            "team1": "AVANT",
            "team1img": "https:\/\/qn.feijing88.com\/feijing-home\/egame\/image\/20190121\/48b9b58ae0814a97844a62d981bda9f1.jpg",
            "team2img": "https:\/\/qn.feijing88.com\/egame\/csgo\/team\/35dbd4e5a101fff12c3368615ff040fd.png",
            "team2": "Paradox",
            "eventsimg": "https:\/\/qn.feijing88.com\/egame\/csgo\/league\/038803234a89e88bdcf7388fc19eb0cd.png",
            "events": "ESEA MDL Season 34 Australia",
            "eventsid": 55,
            "index": "1.25\/3.7",
            "created_at": null,
            "updated_at": null
        },
        ... ...
        {
            "id": 19,
            "gameimg": "https:\/\/www.500bf.com\/static\/index\/img\/csgo_sel_icon.png",
            "game": "CS:GO",
            "time": "15:00",
            "BO": "BO3",
            "team1": "Tikitakan",
            "team1img": "https:\/\/qn.feijing88.com\/feijing-home\/egame\/image\/csgo\/team.png",
            "team2img": "https:\/\/qn.feijing88.com\/feijing-home\/egame\/image\/20190121\/9dab47b972af4930bcfc87e3c62ef507.jpg",
            "team2": "Nexus",
            "eventsimg": "https:\/\/qn.feijing88.com\/egame\/csgo\/league\/6cb32166930104d7c043ca5f470ce21a.png",
            "events": "Nine to Five 3 Dawn",
            "eventsid": 293,
            "index": "1.45\/2.63",
            "created_at": null,
            "updated_at": null
        }
    ]

- 全部游戏完场 ( http://45.157.91.155/GetScoreOver )


    [
        {
            "id": 1,
            "gameimg": "https:\/\/www.500bf.com\/static\/index\/img\/lol_sel_icon.png",
            "game": "\u82f1\u96c4\u8054\u76df",
            "time": "00:09",
            "BO": "BO5",
            "team1": "Team Quesco",
            "team1img": "https:\/\/qn.feijing88.com\/feijing-home\/egame\/image\/2020121\/765de0df0352448aa620c5822c130bd0.png",
            "score": "1-3",
            "team2img": "https:\/\/qn.feijing88.com\/egame\/lol\/team\/f1c9d625b6c6803231ac1e367110edff.png",
            "team2": "CRB",
            "eventsimg": "\/static\/index\/img\/lol_sel_icon.png",
            "events": "2020 LVP SLO\u590f\u5b63\u8d5b",
            "eventsid": 168,
            "index": "4.938\/1.161",
            "created_at": null,
            "updated_at": null
        },
        ... ...
        {
            "id": 14,
            "gameimg": "https:\/\/www.500bf.com\/static\/index\/img\/csgo_sel_icon.png",
            "game": "CS:GO",
            "time": "11:35",
            "BO": "BO1",
            "team1": "Eclipse",
            "team1img": "https:\/\/qn.feijing88.com\/feijing-home\/egame\/image\/csgo\/team.png",
            "score": "14-16",
            "team2img": "https:\/\/qn.feijing88.com\/feijing-home\/egame\/image\/csgo\/team.png",
            "team2": "Northern Forces",
            "eventsimg": "\/static\/index\/img\/csgo_sel_icon.png",
            "events": "IEM New York 2020 North America Open Qualifier 1",
            "eventsid": 300,
            "index": "-\/-",
            "created_at": null,
            "updated_at": null
        }
    ]

- 指定获取游戏完场 ( http://45.157.91.155/ScoreAppointOver/$id )


    [
        {
            "id": 3,
            "gameimg": "https:\/\/www.500bf.com\/static\/index\/img\/csgo_sel_icon.png",
            "game": "CS:GO",
            "time": "01:50",
            "BO": "BO3",
            "team1": "Yeah",
            "team1img": "https:\/\/qn.feijing88.com\/feijing-home\/egame\/image\/202065\/0a576787ee42444ea7167097d3bd1cfa.webp",
            "score": "0-2",
            "team2img": "https:\/\/qn.feijing88.com\/feijing-home\/egame\/image\/20190121\/649231a18f554ab2aa8ec9c50d05e410.jpg",
            "team2": "Cloud9",
            "eventsimg": "\/static\/index\/img\/csgo_sel_icon.png",
            "events": "DreamHack Open Summer 2020 North America",
            "eventsid": 287,
            "index": "4.18\/1.2",
            "created_at": null,
            "updated_at": null
        },
        ... ...
        {
            "id": 14,
            "gameimg": "https:\/\/www.500bf.com\/static\/index\/img\/csgo_sel_icon.png",
            "game": "CS:GO",
            "time": "11:35",
            "BO": "BO1",
            "team1": "Eclipse",
            "team1img": "https:\/\/qn.feijing88.com\/feijing-home\/egame\/image\/csgo\/team.png",
            "score": "14-16",
            "team2img": "https:\/\/qn.feijing88.com\/feijing-home\/egame\/image\/csgo\/team.png",
            "team2": "Northern Forces",
            "eventsimg": "\/static\/index\/img\/csgo_sel_icon.png",
            "events": "IEM New York 2020 North America Open Qualifier 1",
            "eventsid": 300,
            "index": "-\/-",
            "created_at": null,
            "updated_at": null
        }
    ]

### 赛程页面

- 获取当前星期的日期 ( http://45.157.91.155/GetWeek )
    
    
    [
        {
            "date": "08月10日",
            "date2": "2020-08-10",
            "week": "星期一"
        },
        ... ...
        {
            "date": "08月16日",
            "date2": "2020-08-16",
            "week": "星期日"
        }
    ]

- 根据时间获取全部游戏 ( http://45.157.91.155/CourseAll/$date )


    例： http://45.157.91.155/CourseAll/2020-08-19
    [
        {
            "id": 6481,
            "gameimg": "https:\/\/www.500bf.com\/static\/index\/img\/csgo_sel_icon.png",
            "gametype": "CS:GO",
            "matchtime": "2020-08-19 00:30",
            "BO": "BO3",
            "team1": "fnatic",
            "team1img": "https:\/\/qn.feijing88.com\/egame\/csgo\/team\/bfbc68a63f191780e16012047b9371bf.svg",
            "score": "-",
            "team2img": "https:\/\/qn.feijing88.com\/feijing-home\/egame\/image\/20191113\/ce2d725cd4e042cda94e25a667b8a211.svg",
            "team2": "Astralis",
            "eventsimg": "https:\/\/qn.feijing88.com\/feijing-home\/egame\/image\/20190930\/8862ad16343245999942776f25ec5ce7.jpg",
            "events": "ESL One Cologne 2020 Europe",
            "eventsid": 295,
            "created_at": null,
            "updated_at": null
        },
        ... ...
        {
            "id": 6486,
            "gameimg": "https:\/\/www.500bf.com\/static\/index\/img\/csgo_sel_icon.png",
            "gametype": "CS:GO",
            "matchtime": "2020-08-19 21:00",
            "BO": "BO3",
            "team1": "Complexity",
            "team1img": "https:\/\/qn.feijing88.com\/egame\/csgo\/team\/a39c8c7dc65b3962b35de6877f3a9260.svg",
            "score": "-",
            "team2img": "https:\/\/qn.feijing88.com\/feijing-home\/egame\/image\/20190615\/80858015697c4f4caec11b0cf5e2a7f1.jpg",
            "team2": "MAD Lions",
            "eventsimg": "https:\/\/qn.feijing88.com\/feijing-home\/egame\/image\/20190930\/8862ad16343245999942776f25ec5ce7.jpg",
            "events": "ESL One Cologne 2020 Europe",
            "eventsid": 295,
            "created_at": null,
            "updated_at": null
        }
    ]

- 根据时间获取指定游戏 ( http://45.157.91.155/CourseAppoint/$date/$id )

    
    例：http://127.0.0.1:8000/CourseAppoint/2020-08-26/2
    [
        {
            "id": 6493,
            "gameimg": "https:\/\/www.500bf.com\/static\/index\/img\/csgo_sel_icon.png",
            "gametype": "CS:GO",
            "matchtime": "2020-08-26 14:00",
            "BO": "BO3",
            "team1": "ORDER",
            "team1img": "https:\/\/qn.feijing88.com\/feijing-home\/egame\/image\/20190121\/55e8578a0ccf43dc98329eb48364d4df.jpg",
            "score": "-",
            "team2img": "https:\/\/qn.feijing88.com\/feijing-home\/egame\/image\/20190121\/48b9b58ae0814a97844a62d981bda9f1.jpg",
            "team2": "AVANT",
            "eventsimg": "https:\/\/qn.feijing88.com\/egame\/csgo\/league\/8c92150df45c7aca335542058eebc03d.png",
            "events": "ESL One Cologne 2020 Oceania",
            "eventsid": 297,
            "created_at": null,
            "updated_at": null
        },
        {
            "id": 6494,
            "gameimg": "https:\/\/www.500bf.com\/static\/index\/img\/csgo_sel_icon.png",
            "gametype": "CS:GO",
            "matchtime": "2020-08-26 17:30",
            "BO": "BO3",
            "team1": "ViCi",
            "team1img": "https:\/\/qn.feijing88.com\/feijing-home\/egame\/image\/20190121\/0ef4e915c3d7489ca264d1e312d8f110.jpg",
            "score": "-",
            "team2img": "https:\/\/qn.feijing88.com\/egame\/csgo\/team\/8c02728d7bbf685212badc8691557a57.png",
            "team2": "Invictus",
            "eventsimg": "https:\/\/qn.feijing88.com\/egame\/csgo\/league\/d9d1bdc0940952bf4474c3b25cabceb9.png",
            "events": "ESL One Cologne 2020 Asia",
            "eventsid": 298,
            "created_at": null,
            "updated_at": null
        }
    ]

### 直播页面

- http://45.157.91.155/Video/$id
    
    
    
    
    {
        "eventsimg": "https:\/\/qn.feijing88.com\/feijing-home\/egame\/image\/2020612\/f22fd95faa0648aca48e3348fc3ccc60.png",
        "events": "2020 LDL\u590f\u5b63\u8d5b",
        "BO": "BO3",
        "tv": {
            "\u864e\u7259356": "https:\/\/esportsapi.feijing88.com\/live\/v2\/?v=b59260462057d8cac878d00fd60649d3a05eb67129ddc655d0937953d975f8b6fb828cb0fa9e9b509d85157f1fd1993977ca1ce1aeafafc4c598633acf2c9a00c48fafaa8f957987b45df7d36484fbe5",
            "\u6597\u9c7c244": "https:\/\/www.500bf.com\/index\/index\/living\/match_id\/268076636\/idx\/1.html",
            "\u6597\u9c7c194": "https:\/\/esportsapi.feijing88.com\/live\/v2\/?v=6a7446ebd0a9f89d3035ada4ca84edf102d62812364a057cd5c0b1670c9e45cda56efe69c884c145025fb0a7ee5888b4f6915c5e25d2485448c3659fbb9073d7",
            "\u864e\u7259821": "https:\/\/esportsapi.feijing88.com\/live\/v2\/?v=fb15acc87d797891163255e2748ac49b3c6da1fbaa89ff04e88b624fd7d46e1ffb828cb0fa9e9b509d85157f1fd1993977ca1ce1aeafafc4c598633acf2c9a0055d53445e0d0fafd98edde00faea89c7",
            "\u864e\u72592077": "https:\/\/esportsapi.feijing88.com\/live\/v2\/?v=f2dcce8ef756cdd913583bc3a8edc643991a6a350ed32e96eb46208803058c14fb828cb0fa9e9b509d85157f1fd1993977ca1ce1aeafafc4c598633acf2c9a003de7089fe68971030e851acfd0fd79f2"
        },
        "team1": "OMD",
        "team1img": "https:\/\/qn.feijing88.com\/feijing-home\/egame\/image\/202083\/c3feb03d14124449ab7d3e227601c2fc.png",
        "team1winnum": 0,
        "team2winnum": 0,
        "team2img": "https:\/\/qn.feijing88.com\/feijing-home\/egame\/image\/20190920\/365503c142524f51965a3adb9a2a6c7d.png",
        "team2": "LNG.A",
        "time": "08\u670810\u65e5 13:00"
    }

### 赛事页面

- 根据ID获取赛事所有比赛 ( http://45.157.91.155/Match/$id )


    http://45.157.91.155/Match/33
    
    [
        {
            "id": 532,
            "event": "Home Camp",
            "eventid": "33",
            "time": "04-24\u00a021:00",
            "team1img": "https:\/\/qn.feijing88.com\/egame\/dota\/team\/baf4b7e3d5a245068eb6d8071a307b42.png",
            "team1": "Cyber TRAKTOR",
            "score": "0-0",
            "team2img": "https:\/\/qn.feijing88.com\/egame\/dota\/team\/d53a81ded73b42ef96e9a2ed6c90e507.png",
            "team2": "NOVA",
            "BO": "BO2",
            "created_at": null,
            "updated_at": null
        },
        ... ...
        {
            "id": 557,
            "event": "Home Camp",
            "eventid": "33",
            "time": "05-05\u00a001:45",
            "team1img": "https:\/\/qn.feijing88.com\/egame\/dota\/team\/d53a81ded73b42ef96e9a2ed6c90e507.png",
            "team1": "NOVA",
            "score": "3-0",
            "team2img": "https:\/\/qn.feijing88.com\/feijing-home\/egame\/image\/20181126\/d4bf8b386e5747dcb20070f4cb35283f.jpg",
            "team2": "friends",
            "BO": "BO5",
            "created_at": null,
            "updated_at": null
        }
    ]


### 资讯页面

- 资讯 ( http://45.157.91.155/Information )


    {
        "current_page": 1,
        "data": [
            {
                "id": 3418,
                "thumbnail": "http:\/\/45.157.91.154\/static\/information\/15975495951735.jpg",
                "title": "\u7a33\u5b9a\u9635\u5bb9\u6c38\u4e0d\u53d8\uff0c10.16\u7248\u672c\u7b54\u6848\uff1a\u91cd\u79d8\u5b87\u822a\u72d9",
                "gametype": "\u82f1\u96c4\u8054\u76df",
                "gametypeid": 3,
                "time": "2020\u5e7408\u670816\u65e5 11:46",
                "body": "<div class=\"new_conts\">\n<p>\u597d\u591a\u5c0f\u4f19\u4f34\u4eec\u4e0d\u77e5\u905310.16\u7248\u672c\u73a9\u4ec0\u4e48\uff0c\u4eca\u5929\u5c31\u7ed9\u5927\u5bb6\u63a8\u8350\u4e00\u4e2a\u7a33\u5b9a\u4e0a\u5206\u7684\u9635\u5bb9\uff0c\u91cd\u79d8\u5b87\u822a\u72d9\u7684\u73a9\u6cd5\u3002<\/p>\n<h2>\u5b8c\u7f8e\u9635\u5bb9<\/h2>\n<p><img class=\"lazy\" data-original=\"https:\/\/si1.go2yd.com\/get-image\/0jE74vvnaz2\" style=\"display:block; margin-left:auto; margin-right:auto;\" \/><\/p>\n<p>\u8be5\u9635\u5bb9\u9700\u89819\u4eba\u53e3\uff0c\u5206\u522b\u662f\u94c1\u7537\u3001\u7334\u5b50\u3001\u6cf0\u5766\u3001\u6770\u65af\u3001\u5361\u5c14\u739b\u3001\u63d0\u83ab\u3001\u7eb3\u5c14\u3001\u70ec\u548c\u7d22\u62c9\u5361\u3002<\/p>\n<h2>\u9635\u5bb9\u7f81\u7eca<\/h2>\n<p>\u3010\u5b87\u822a\u54583\/3\u3011\u3010\u5b87\u822a\u5458\u3011\u82f1\u96c4\u7684\u6cd5\u529b\u6d88\u8017\u51cf\u5c1130\u3002<\/p>\n<p><img class=\"lazy\" data-original=\"https:\/\/si1.go2yd.com\/get-image\/0jE74vhuGf2\" style=\"display:block; margin-left:auto; margin-right:auto;\" \/><\/p>\n<p>\u3010\u91cd\u88c5\u6218\u58eb4\/4\u3011\u91cd\u88c5\u6218\u58eb\u4eec\u83b7\u5f97\u989d\u5916\u62a4\u7532\u3002<\/p>\n<p><img class=\"lazy\" data-original=\"https:\/\/si1.go2yd.com\/get-image\/0jE74vwhmmu\" style=\"display:block; margin-left:auto; margin-right:auto;\" \/><\/p>\n<p>\u3010\u6697\u661f3\/3\u3011\u3010\u6697\u661f\u3011\u7f81\u7eca\u73b0\u5728\u4f1a\u5728\u4e00\u540d\u53cb\u65b9\u9635\u4ea1\u65f6\u89e6\u53d1\uff0c\u800c\u975e\u4ee5\u524d\u7684\u9700\u8981\u5728\u4e00\u540d\u3010\u6697\u661f\u3011\u82f1\u96c4\u9635\u4ea1\u65f6\u89e6\u53d1<\/p>\n<p><img class=\"lazy\" data-original=\"https:\/\/si1.go2yd.com\/get-image\/0jE74viwWXo\" style=\"display:block; margin-left:auto; margin-right:auto;\" \/><\/p>\n<p>\u3010\u72d9\u795e2\/2\u3011\u3010\u72d9\u795e\u3011\u4e0e\u76ee\u6807\u4e4b\u95f4\u6bcf\u76f8\u8ddd1\u683c\uff0c\u9020\u6210\u7684\u4f24\u5bb3\u5c31\u4f1a\u83b7\u5f97\u4e00\u5b9a\u63d0\u5347\u3002<\/p>\n<p><img class=\"lazy\" data-original=\"https:\/\/si1.go2yd.com\/get-image\/0jE74vl5jKC\" style=\"display:block; margin-left:auto; margin-right:auto;\" \/><\/p>\n<p>\u3010\u79d8\u672f\u5e082\/2\u3011\u6240\u6709\u53cb\u519b\u83b7\u5f97\u9b54\u6cd5\u6297\u6027\u3002<\/p>\n<p><img class=\"lazy\" data-original=\"https:\/\/si1.go2yd.com\/get-image\/0jE74voa08m\" style=\"display:block; margin-left:auto; margin-right:auto;\" \/><\/p>\n<h2>\u9635\u5bb9\u4e3bC<\/h2>\n<p>\u8fd9\u5957\u9635\u5bb9\u4e3bC\u5206\u522b\u6709\u4e09\u4e2a\u82f1\u96c4\u3002<\/p>\n<p><img class=\"lazy\" data-original=\"https:\/\/si1.go2yd.com\/get-image\/0jE74vXbrn6\" style=\"display:block; margin-left:auto; margin-right:auto;\" \/><\/p>\n<p>\u4f5c\u4e3a\u524d\u6392\u627f\u4f24\u7684\u7334\u5b50\uff0c\u5c5e\u6027\u975e\u5e38\u7684\u9ad8\uff0c\u518d\u7ed9\u4e0a\u4ed6\u4e09\u4ef6\u9632\u5fa1\u88c5\u5907\uff0c\u5c31\u66f4\u52a0\u7684\u8089\u4e86\u3002<\/p>\n<p>\u53cd\u4f24\u7532\u53ef\u4ee5\u62b5\u6297\u7269\u7406\u4f24\u5bb3\u4ee5\u53ca\u5e73A\uff0c\u79bb\u5b50\u706b\u82b1\u53ef\u4ee5\u9488\u5bf9\u5feb\u901f\u91ca\u653e\u6280\u80fd\u7684\u6cd5\u5e08\u7b49\u82f1\u96c4\uff0c\u72c2\u5f92\u5219\u662f\u589e\u52a0\u7334\u5b50\u7684\u8840\u91cf\u3002<\/p>\n<p>\u6cd5\u7cfb\u88c5\u5907\u5219\u662f\u7ed9\u5230\u63d0\u83ab\uff0c\u84dd\u9738\u7b26\u642d\u914d\u5b87\u822a\u5458\u7f81\u7eca\uff0c\u53ef\u4ee5\u8ba9\u63d0\u83ab\u4e0d\u65ad\u7684\u6254\u8611\u83c7\uff0c\u9b3c\u4e66\u548c\u5e3d\u5b50\u5219\u662f\u63d0\u5347\u4e86\u63d0\u83ab\u7684\u4f24\u5bb3\u3002<\/p>\n<p>\u70ec\u5219\u8981\u7ed9\u5230\u6700\u4e3a\u5173\u952e\u7684\u590d\u6d3b\u7532\uff0c\u6709\u4e86\u590d\u6d3b\u7532\u70ec\u5c31\u6709\u5bb9\u9519\u7387\uff0c\u53ef\u4ee5\u7ad9\u8d77\u6765\u7b2c\u4e8c\u6b21\u8f93\u51fa\uff0c\u8f7b\u8bed\u548c\u65e0\u5c3d\u5728\u642d\u914d\u4e0a\u72d9\u795e\u7684\u7f81\u7eca\uff0c\u53ef\u4ee5\u8ba9\u70ec\u4f24\u5bb3\u6700\u5927\u5316\u3002<\/p>\n<h2>\u9635\u5bb9\u73a9\u6cd5<\/h2>\n<p>\u56e0\u4e3a\u8fd9\u5957\u9635\u5bb9\u9700\u8981\u7684\u662f9\u4eba\u53e3\u6210\u578b\uff0c\u5e76\u4e14\u5f88\u591a\u82f1\u96c4\u90fd\u662f4\u91d1\u5e01\u4ee5\u4e0a\uff0c\u6240\u4ee5\u4e00\u5b9a\u8981\u63a7\u597d\u7ecf\u6d4e\uff0c\u524d\u671f\u4e0d\u7ba1\u662f\u8fde\u80dc\u4e5f\u597d\u8fde\u8d25\u4e5f\u597d\uff0c\u4e00\u5b9a\u8981\u5feb\u901f\u7684\u6512\u597d50\u91d1\u5e01\u3002<\/p>\n<p><img class=\"lazy\" data-original=\"https:\/\/si1.go2yd.com\/get-image\/0jE77C1VYjw\" style=\"display:block; margin-left:auto; margin-right:auto;\" \/><\/p>\n<p>\u5982\u679c\u662f\u8fde\u80dc\uff0c\u53ef\u4ee5\u5229\u7528\u5229\u606f\u5feb\u901f\u7684\u63d0\u5347\u4eba\u53e3\uff0c\u628a\u8fde\u80dc\u4e00\u76f4\u6253\u4e0b\u53bb\u3002\u5982\u679c\u662f\u8fde\u8d25\uff0c\u53ef\u4ee5\u5229\u7528\u5229\u606f\u8c03\u6574\u9635\u5bb9\uff0c\u5b8c\u5584\u4e00\u4e0b\u6253\u8fde\u80dc\u3002<\/p>\n<p>\u5f538\u4eba\u53e3\u4e4b\u540e\uff0c\u9635\u5bb9\u7b97\u662f\u57fa\u672c\u6210\u578b\uff0c\u53ef\u4ee5\u6839\u7edd\u9635\u5bb9\u7b49\u7ea7\uff0c\u9009\u62e9\u662f\u5426\u51b29\u3002\u4e00\u65e6\u4e0a9\uff0c\u76f4\u63a5AllinD\u5361\uff0c\u51b3\u8d5b\u5708\u8981\u8bb0\u4f4f\u8c03\u6574\u4e3bC\u7684\u7ad9\u4f4d\uff0c\u4e0d\u8981\u88ab\u51cc\u98ce\u5439\u8d77\u6765\u3002<\/p>\n<h2>\u603b\u7ed3<\/h2>\n<p>\u91cd\u79d8\u5b87\u822a\u72d9\u662f\u4e00\u4e2a\u975e\u5e38\u666e\u904d\u7684\u73a9\u6cd5\uff0c\u8fd9\u5957\u73a9\u6cd5\u6709\u673a\u4f1a\u53bb\u51b2\u51fb\u7b2c\u4e00\uff0c\u4fdd\u8bc1\u524d\u56db\u662f\u7a33\u5b9a\u7684\uff0c\u662f\u975e\u5e38\u9002\u5408\u7528\u6765\u4e0a\u5206\u7684\u73a9\u6cd5\uff0c\u5404\u4f4d\u5c0f\u4f19\u4f34\u4eec\u8d76\u7d27\u53bb\u8bd5\u8bd5\u5427\u3002<\/p><span style=\"font-size:16px;font-family:Microsoft YaHei;color:#E53333;text-indent:2em\"><\/span> <\/div>\n",
                "created_at": null,
                "updated_at": null,
                "unix": "1597578360"
            },
            ... ...
            {
                "id": 3427,
                "thumbnail": "http:\/\/45.157.91.154\/static\/information\/15974640608590.jpg",
                "title": "10.16\u6392\u4f4d\u4e0a\u5206\u201c\u6bd2\u7624\u201d \u4e0a\u8defAP\u5c0f\u4e11\u72e1\u733e\u65e0\u6bd4",
                "gametype": "\u82f1\u96c4\u8054\u76df",
                "gametypeid": 3,
                "time": "2020\u5e7408\u670815\u65e5 12:01",
                "body": "<div class=\"new_conts\">\n<p>\u54c8\u55bd\u5404\u4f4d\u5c0f\u4f19\u4f34\u4eec\uff0c\u76f8\u4fe1\u5927\u5bb6\u5728\u6392\u4f4d\u4e2d\u90fd\u9047\u5230\u8fc7\u5c0f\u4e11\u8fd9\u4e2a\u82f1\u96c4\uff0c\u5e76\u4e14\u88ab\u8fd9\u4e2a\u82f1\u96c4\u201c\u6076\u5fc3\u201d\u8fc7\u5f88\u591a\u56de\u3002\u8fd9\u4e2a\u82f1\u96c4\u7684\u673a\u5236\u5bfc\u81f4\u4e86\u8be5\u82f1\u96c4\u5f88\u8ba8\u4eba\u538c\uff0c\u4e5f\u88ab\u73a9\u5bb6\u4eec\u79f0\u4e4b\u4e3a\u201c\u6bd2\u7624\u201d\u4eca\u5929\u5c31\u7ed9\u5927\u5bb6\u63a8\u8350\u8fd9\u4e2a\u4e0a\u5206\u201c\u6bd2\u7624\u201dAP\u5c0f\u4e11\u7684\u73a9\u6cd5\u3002<\/p>\n<p><img class=\"lazy\" data-original=\"https:\/\/si1.go2yd.com\/get-image\/0jCTBV01ZBo\" style=\"display:block; margin-left:auto; margin-right:auto;\" \/><\/p>\n<h2>\u7b26\u6587\u9009\u62e9<\/h2>\n<p><img class=\"lazy\" data-original=\"https:\/\/si1.go2yd.com\/get-image\/0jCTBUp2bcO\" style=\"display:block; margin-left:auto; margin-right:auto;\" \/><\/p>\n<p>\u8fd9\u5957\u9635\u5bb9\u4e3b\u63a8\u7684\u662fAP\uff0c\u5728\u7b26\u6587\u52a0\u70b9\u4e0a\uff0c\u9009\u62e9\u6d88\u8017\u80fd\u529b\u6700\u5f3a\u7684\u5deb\u672f\u7cfb\u5f57\u661f\u4e3a\u7b26\u6587\u57fa\u77f3\u3002\u526f\u7cfb\u7b26\u6587\u9009\u62e9\u4e3b\u5bb0\u7cfb\u3002<\/p>\n<p>\u8fd9\u5957\u7b26\u6587\u9009\u62e9\u53ef\u4ee5\u8ba9\u5c0f\u4e11\u5728\u4e0a\u8def\u6d88\u8017\u80fd\u529b\u66f4\u5f3a\uff0c\u53ef\u4ee5\u901a\u8fc7E\u6280\u80fd\u89e6\u53d1\u5f57\u661f\u8fdb\u884c\u7ebf\u4e0a\u6d88\u8017\uff0c\u5e76\u4e14\u8fd8\u6709\u56de\u84dd\u4ee5\u53ca\u56de\u8840\u3002<\/p>\n<h2>\u88c5\u5907\u9009\u62e9<\/h2>\n<p><img class=\"lazy\" data-original=\"https:\/\/si1.go2yd.com\/get-image\/0jCTBTrjO3U\" style=\"display:block; margin-left:auto; margin-right:auto;\" \/><\/p>\n<p>\u88c5\u5907\u9009\u62e9\u4e0a\uff0c\u4f18\u5148\u51fa\u6d77\u514b\u65af\u79d1\u6280\u8170\u5e26\uff0c\u6709\u4e86\u8170\u5e26\u4e4b\u540e\u4e0d\u7ba1\u662f\u6e05\u7ebf\u80fd\u529b\u8fd8\u662f\u8ffd\u51fb\u80fd\u529b\u90fd\u4e0a\u4e00\u4e2a\u6863\u6b21\u3002\u4e4b\u540e\u9009\u62e9\u5362\u767b\u56de\u84dd\u4fdd\u8bc1\u6709\u6301\u7eed\u8f93\u51fa\u7684\u80fd\u529b\uff0c\u5927\u5e3d\u5b50\u548c\u6cd5\u7a7f\u68d2\u589e\u52a0\u5c0f\u4e11\u7684\u4f24\u5bb3\u3002<\/p>\n<h2>\u6280\u80fd\u9009\u62e9<\/h2>\n<p><img class=\"lazy\" data-original=\"https:\/\/si1.go2yd.com\/get-image\/0jCTBUl6B7Y\" style=\"display:block; margin-left:auto; margin-right:auto;\" \/><\/p>\n<p>\u6280\u80fd\u52a0\u70b9\u4e0a\uff0c\u9009\u62e9\u4e3bE\u526fW\u3002<\/p>\n<h2>\u82f1\u96c4\u73a9\u6cd5<\/h2>\n<p>1\u7ea7\u7684\u65f6\u5019\u70b9\u51faE\u6280\u80fd\uff0c\u5728\u7ebf\u4e0a\u591a\u7528E\u6280\u80fd\u6d88\u8017\u30023\u7ea7\u7684\u65f6\u5019\u5c31\u53ef\u4ee5\u52fe\u5f15\u5bf9\u65b9\u7684\u8d70\u4f4d\uff0c\u628a\u654c\u65b9\u5f15\u5230\u6709\u76d2\u5b50\u7684\u5730\u65b9\uff0c\u7136\u540e\u6050\u60e7\u6253\u51fa\u4e00\u5957\u6d88\u8017\u3002\u5982\u679c\u8fd9\u4e2a\u65f6\u5019\u5bf9\u9762\u4e0d\u56de\u5bb6\u9009\u62e9\u7ebf\u4e0a\u7ee7\u7eed\u5403\u7ebf\uff0c\u8fd9\u4e2a\u65f6\u5019\u5c31\u627e\u673a\u4f1aQ\u9690\u8eab\u5728\u4ed6\u8eab\u540e\u653e\u76d2\u5b50\uff0c\u7136\u540e\u76f4\u63a5\u51b2\u4e0a\u53bb\u51fb\u6740\u3002<\/p>\n<p><img class=\"lazy\" data-original=\"https:\/\/si1.go2yd.com\/get-image\/0jCTE9rxyAC\" style=\"display:block; margin-left:auto; margin-right:auto;\" \/><\/p>\n<p>\u56e2\u6218\u7684\u65f6\u5019\uff0c\u53ef\u4ee5\u591a\u5229\u7528\u76d2\u5b50\u7684\u6446\u653e\u4f4d\u7f6e\u8fdb\u884c\u56e2\u6218\u3002\u6216\u8005\u53ef\u4ee5\u7ed5\u540e\u5207C\u4f4d\uff0c\u7136\u540e\u91cc\u7528Q\u6280\u80fd\u7684\u9690\u8eab\u9003\u8d70\u3002<\/p>\n<p><img class=\"lazy\" data-original=\"https:\/\/si1.go2yd.com\/get-image\/0jCTEACNads\" style=\"display:block; margin-left:auto; margin-right:auto;\" \/><\/p>\n<p>AP\u4e0a\u5355\u5c0f\u4e11\u8fd8\u662f\u4ee5\u5355\u5e26\u4e3a\u4e3b\uff0c\u4e00\u822c\u4eba\u6765\u6293\u81f3\u5c11\u4e24\u4eba\u4ee5\u4e0a\u624d\u80fd\u6293\u6b7b\u3002<\/p>\n<h2>\u603b\u7ed3<\/h2>\n<p><img class=\"lazy\" data-original=\"https:\/\/si1.go2yd.com\/get-image\/0jCTBUqAz2W\" style=\"display:block; margin-left:auto; margin-right:auto;\" \/><\/p>\n<p>\u8fd9\u4e2a\u82f1\u96c4\u7684\u73a9\u6cd5\u8fc7\u4e8e\u6bd2\u7624\uff0c\u73a9\u5bb6\u4eec\u53ef\u4ee5\u7528\u8fd9\u5957\u73a9\u6cd5\u53bb\u4e0a\u6ce2\u5206\uff0c\u5404\u4f4d\u5c0f\u4f19\u4f34\u4eec\u8d76\u7d27\u884c\u52a8\u8d77\u6765\u5427\u3002<\/p><span style=\"font-size:16px;font-family:Microsoft YaHei;color:#E53333;text-indent:2em\"><\/span> <\/div>\n",
                "created_at": null,
                "updated_at": null,
                "unix": "1597492860"
            }
        ],
        "first_page_url": "http:\/\/127.0.0.1:8000\/Information?page=1",
        "from": 1,
        "last_page": 47,
        "last_page_url": "http:\/\/127.0.0.1:8000\/Information?page=47",
        "next_page_url": "http:\/\/127.0.0.1:8000\/Information?page=2",
        "path": "http:\/\/127.0.0.1:8000\/Information",
        "per_page": 10,
        "prev_page_url": null,
        "to": 10,
        "total": 469
    }

- 指定游戏资讯 ( http://45.157.91.155/AppointInformation/$id )


    {
        "current_page": 1,
        "data": [
            {
                "id": 3418,
                "thumbnail": "http:\/\/45.157.91.154\/static\/information\/15975495951735.jpg",
                "title": "\u7a33\u5b9a\u9635\u5bb9\u6c38\u4e0d\u53d8\uff0c10.16\u7248\u672c\u7b54\u6848\uff1a\u91cd\u79d8\u5b87\u822a\u72d9",
                "gametype": "\u82f1\u96c4\u8054\u76df",
                "gametypeid": 3,
                "time": "2020\u5e7408\u670816\u65e5 11:46",
                "body": "<div class=\"new_conts\">\n<p>\u597d\u591a\u5c0f\u4f19\u4f34\u4eec\u4e0d\u77e5\u905310.16\u7248\u672c\u73a9\u4ec0\u4e48\uff0c\u4eca\u5929\u5c31\u7ed9\u5927\u5bb6\u63a8\u8350\u4e00\u4e2a\u7a33\u5b9a\u4e0a\u5206\u7684\u9635\u5bb9\uff0c\u91cd\u79d8\u5b87\u822a\u72d9\u7684\u73a9\u6cd5\u3002<\/p>\n<h2>\u5b8c\u7f8e\u9635\u5bb9<\/h2>\n<p><img class=\"lazy\" data-original=\"https:\/\/si1.go2yd.com\/get-image\/0jE74vvnaz2\" style=\"display:block; margin-left:auto; margin-right:auto;\" \/><\/p>\n<p>\u8be5\u9635\u5bb9\u9700\u89819\u4eba\u53e3\uff0c\u5206\u522b\u662f\u94c1\u7537\u3001\u7334\u5b50\u3001\u6cf0\u5766\u3001\u6770\u65af\u3001\u5361\u5c14\u739b\u3001\u63d0\u83ab\u3001\u7eb3\u5c14\u3001\u70ec\u548c\u7d22\u62c9\u5361\u3002<\/p>\n<h2>\u9635\u5bb9\u7f81\u7eca<\/h2>\n<p>\u3010\u5b87\u822a\u54583\/3\u3011\u3010\u5b87\u822a\u5458\u3011\u82f1\u96c4\u7684\u6cd5\u529b\u6d88\u8017\u51cf\u5c1130\u3002<\/p>\n<p><img class=\"lazy\" data-original=\"https:\/\/si1.go2yd.com\/get-image\/0jE74vhuGf2\" style=\"display:block; margin-left:auto; margin-right:auto;\" \/><\/p>\n<p>\u3010\u91cd\u88c5\u6218\u58eb4\/4\u3011\u91cd\u88c5\u6218\u58eb\u4eec\u83b7\u5f97\u989d\u5916\u62a4\u7532\u3002<\/p>\n<p><img class=\"lazy\" data-original=\"https:\/\/si1.go2yd.com\/get-image\/0jE74vwhmmu\" style=\"display:block; margin-left:auto; margin-right:auto;\" \/><\/p>\n<p>\u3010\u6697\u661f3\/3\u3011\u3010\u6697\u661f\u3011\u7f81\u7eca\u73b0\u5728\u4f1a\u5728\u4e00\u540d\u53cb\u65b9\u9635\u4ea1\u65f6\u89e6\u53d1\uff0c\u800c\u975e\u4ee5\u524d\u7684\u9700\u8981\u5728\u4e00\u540d\u3010\u6697\u661f\u3011\u82f1\u96c4\u9635\u4ea1\u65f6\u89e6\u53d1<\/p>\n<p><img class=\"lazy\" data-original=\"https:\/\/si1.go2yd.com\/get-image\/0jE74viwWXo\" style=\"display:block; margin-left:auto; margin-right:auto;\" \/><\/p>\n<p>\u3010\u72d9\u795e2\/2\u3011\u3010\u72d9\u795e\u3011\u4e0e\u76ee\u6807\u4e4b\u95f4\u6bcf\u76f8\u8ddd1\u683c\uff0c\u9020\u6210\u7684\u4f24\u5bb3\u5c31\u4f1a\u83b7\u5f97\u4e00\u5b9a\u63d0\u5347\u3002<\/p>\n<p><img class=\"lazy\" data-original=\"https:\/\/si1.go2yd.com\/get-image\/0jE74vl5jKC\" style=\"display:block; margin-left:auto; margin-right:auto;\" \/><\/p>\n<p>\u3010\u79d8\u672f\u5e082\/2\u3011\u6240\u6709\u53cb\u519b\u83b7\u5f97\u9b54\u6cd5\u6297\u6027\u3002<\/p>\n<p><img class=\"lazy\" data-original=\"https:\/\/si1.go2yd.com\/get-image\/0jE74voa08m\" style=\"display:block; margin-left:auto; margin-right:auto;\" \/><\/p>\n<h2>\u9635\u5bb9\u4e3bC<\/h2>\n<p>\u8fd9\u5957\u9635\u5bb9\u4e3bC\u5206\u522b\u6709\u4e09\u4e2a\u82f1\u96c4\u3002<\/p>\n<p><img class=\"lazy\" data-original=\"https:\/\/si1.go2yd.com\/get-image\/0jE74vXbrn6\" style=\"display:block; margin-left:auto; margin-right:auto;\" \/><\/p>\n<p>\u4f5c\u4e3a\u524d\u6392\u627f\u4f24\u7684\u7334\u5b50\uff0c\u5c5e\u6027\u975e\u5e38\u7684\u9ad8\uff0c\u518d\u7ed9\u4e0a\u4ed6\u4e09\u4ef6\u9632\u5fa1\u88c5\u5907\uff0c\u5c31\u66f4\u52a0\u7684\u8089\u4e86\u3002<\/p>\n<p>\u53cd\u4f24\u7532\u53ef\u4ee5\u62b5\u6297\u7269\u7406\u4f24\u5bb3\u4ee5\u53ca\u5e73A\uff0c\u79bb\u5b50\u706b\u82b1\u53ef\u4ee5\u9488\u5bf9\u5feb\u901f\u91ca\u653e\u6280\u80fd\u7684\u6cd5\u5e08\u7b49\u82f1\u96c4\uff0c\u72c2\u5f92\u5219\u662f\u589e\u52a0\u7334\u5b50\u7684\u8840\u91cf\u3002<\/p>\n<p>\u6cd5\u7cfb\u88c5\u5907\u5219\u662f\u7ed9\u5230\u63d0\u83ab\uff0c\u84dd\u9738\u7b26\u642d\u914d\u5b87\u822a\u5458\u7f81\u7eca\uff0c\u53ef\u4ee5\u8ba9\u63d0\u83ab\u4e0d\u65ad\u7684\u6254\u8611\u83c7\uff0c\u9b3c\u4e66\u548c\u5e3d\u5b50\u5219\u662f\u63d0\u5347\u4e86\u63d0\u83ab\u7684\u4f24\u5bb3\u3002<\/p>\n<p>\u70ec\u5219\u8981\u7ed9\u5230\u6700\u4e3a\u5173\u952e\u7684\u590d\u6d3b\u7532\uff0c\u6709\u4e86\u590d\u6d3b\u7532\u70ec\u5c31\u6709\u5bb9\u9519\u7387\uff0c\u53ef\u4ee5\u7ad9\u8d77\u6765\u7b2c\u4e8c\u6b21\u8f93\u51fa\uff0c\u8f7b\u8bed\u548c\u65e0\u5c3d\u5728\u642d\u914d\u4e0a\u72d9\u795e\u7684\u7f81\u7eca\uff0c\u53ef\u4ee5\u8ba9\u70ec\u4f24\u5bb3\u6700\u5927\u5316\u3002<\/p>\n<h2>\u9635\u5bb9\u73a9\u6cd5<\/h2>\n<p>\u56e0\u4e3a\u8fd9\u5957\u9635\u5bb9\u9700\u8981\u7684\u662f9\u4eba\u53e3\u6210\u578b\uff0c\u5e76\u4e14\u5f88\u591a\u82f1\u96c4\u90fd\u662f4\u91d1\u5e01\u4ee5\u4e0a\uff0c\u6240\u4ee5\u4e00\u5b9a\u8981\u63a7\u597d\u7ecf\u6d4e\uff0c\u524d\u671f\u4e0d\u7ba1\u662f\u8fde\u80dc\u4e5f\u597d\u8fde\u8d25\u4e5f\u597d\uff0c\u4e00\u5b9a\u8981\u5feb\u901f\u7684\u6512\u597d50\u91d1\u5e01\u3002<\/p>\n<p><img class=\"lazy\" data-original=\"https:\/\/si1.go2yd.com\/get-image\/0jE77C1VYjw\" style=\"display:block; margin-left:auto; margin-right:auto;\" \/><\/p>\n<p>\u5982\u679c\u662f\u8fde\u80dc\uff0c\u53ef\u4ee5\u5229\u7528\u5229\u606f\u5feb\u901f\u7684\u63d0\u5347\u4eba\u53e3\uff0c\u628a\u8fde\u80dc\u4e00\u76f4\u6253\u4e0b\u53bb\u3002\u5982\u679c\u662f\u8fde\u8d25\uff0c\u53ef\u4ee5\u5229\u7528\u5229\u606f\u8c03\u6574\u9635\u5bb9\uff0c\u5b8c\u5584\u4e00\u4e0b\u6253\u8fde\u80dc\u3002<\/p>\n<p>\u5f538\u4eba\u53e3\u4e4b\u540e\uff0c\u9635\u5bb9\u7b97\u662f\u57fa\u672c\u6210\u578b\uff0c\u53ef\u4ee5\u6839\u7edd\u9635\u5bb9\u7b49\u7ea7\uff0c\u9009\u62e9\u662f\u5426\u51b29\u3002\u4e00\u65e6\u4e0a9\uff0c\u76f4\u63a5AllinD\u5361\uff0c\u51b3\u8d5b\u5708\u8981\u8bb0\u4f4f\u8c03\u6574\u4e3bC\u7684\u7ad9\u4f4d\uff0c\u4e0d\u8981\u88ab\u51cc\u98ce\u5439\u8d77\u6765\u3002<\/p>\n<h2>\u603b\u7ed3<\/h2>\n<p>\u91cd\u79d8\u5b87\u822a\u72d9\u662f\u4e00\u4e2a\u975e\u5e38\u666e\u904d\u7684\u73a9\u6cd5\uff0c\u8fd9\u5957\u73a9\u6cd5\u6709\u673a\u4f1a\u53bb\u51b2\u51fb\u7b2c\u4e00\uff0c\u4fdd\u8bc1\u524d\u56db\u662f\u7a33\u5b9a\u7684\uff0c\u662f\u975e\u5e38\u9002\u5408\u7528\u6765\u4e0a\u5206\u7684\u73a9\u6cd5\uff0c\u5404\u4f4d\u5c0f\u4f19\u4f34\u4eec\u8d76\u7d27\u53bb\u8bd5\u8bd5\u5427\u3002<\/p><span style=\"font-size:16px;font-family:Microsoft YaHei;color:#E53333;text-indent:2em\"><\/span> <\/div>\n",
                "created_at": null,
                "updated_at": null,
                "unix": "1597578360"
            },
            ... ...
            {
                "id": 3427,
                "thumbnail": "http:\/\/45.157.91.154\/static\/information\/15974640608590.jpg",
                "title": "10.16\u6392\u4f4d\u4e0a\u5206\u201c\u6bd2\u7624\u201d \u4e0a\u8defAP\u5c0f\u4e11\u72e1\u733e\u65e0\u6bd4",
                "gametype": "\u82f1\u96c4\u8054\u76df",
                "gametypeid": 3,
                "time": "2020\u5e7408\u670815\u65e5 12:01",
                "body": "<div class=\"new_conts\">\n<p>\u54c8\u55bd\u5404\u4f4d\u5c0f\u4f19\u4f34\u4eec\uff0c\u76f8\u4fe1\u5927\u5bb6\u5728\u6392\u4f4d\u4e2d\u90fd\u9047\u5230\u8fc7\u5c0f\u4e11\u8fd9\u4e2a\u82f1\u96c4\uff0c\u5e76\u4e14\u88ab\u8fd9\u4e2a\u82f1\u96c4\u201c\u6076\u5fc3\u201d\u8fc7\u5f88\u591a\u56de\u3002\u8fd9\u4e2a\u82f1\u96c4\u7684\u673a\u5236\u5bfc\u81f4\u4e86\u8be5\u82f1\u96c4\u5f88\u8ba8\u4eba\u538c\uff0c\u4e5f\u88ab\u73a9\u5bb6\u4eec\u79f0\u4e4b\u4e3a\u201c\u6bd2\u7624\u201d\u4eca\u5929\u5c31\u7ed9\u5927\u5bb6\u63a8\u8350\u8fd9\u4e2a\u4e0a\u5206\u201c\u6bd2\u7624\u201dAP\u5c0f\u4e11\u7684\u73a9\u6cd5\u3002<\/p>\n<p><img class=\"lazy\" data-original=\"https:\/\/si1.go2yd.com\/get-image\/0jCTBV01ZBo\" style=\"display:block; margin-left:auto; margin-right:auto;\" \/><\/p>\n<h2>\u7b26\u6587\u9009\u62e9<\/h2>\n<p><img class=\"lazy\" data-original=\"https:\/\/si1.go2yd.com\/get-image\/0jCTBUp2bcO\" style=\"display:block; margin-left:auto; margin-right:auto;\" \/><\/p>\n<p>\u8fd9\u5957\u9635\u5bb9\u4e3b\u63a8\u7684\u662fAP\uff0c\u5728\u7b26\u6587\u52a0\u70b9\u4e0a\uff0c\u9009\u62e9\u6d88\u8017\u80fd\u529b\u6700\u5f3a\u7684\u5deb\u672f\u7cfb\u5f57\u661f\u4e3a\u7b26\u6587\u57fa\u77f3\u3002\u526f\u7cfb\u7b26\u6587\u9009\u62e9\u4e3b\u5bb0\u7cfb\u3002<\/p>\n<p>\u8fd9\u5957\u7b26\u6587\u9009\u62e9\u53ef\u4ee5\u8ba9\u5c0f\u4e11\u5728\u4e0a\u8def\u6d88\u8017\u80fd\u529b\u66f4\u5f3a\uff0c\u53ef\u4ee5\u901a\u8fc7E\u6280\u80fd\u89e6\u53d1\u5f57\u661f\u8fdb\u884c\u7ebf\u4e0a\u6d88\u8017\uff0c\u5e76\u4e14\u8fd8\u6709\u56de\u84dd\u4ee5\u53ca\u56de\u8840\u3002<\/p>\n<h2>\u88c5\u5907\u9009\u62e9<\/h2>\n<p><img class=\"lazy\" data-original=\"https:\/\/si1.go2yd.com\/get-image\/0jCTBTrjO3U\" style=\"display:block; margin-left:auto; margin-right:auto;\" \/><\/p>\n<p>\u88c5\u5907\u9009\u62e9\u4e0a\uff0c\u4f18\u5148\u51fa\u6d77\u514b\u65af\u79d1\u6280\u8170\u5e26\uff0c\u6709\u4e86\u8170\u5e26\u4e4b\u540e\u4e0d\u7ba1\u662f\u6e05\u7ebf\u80fd\u529b\u8fd8\u662f\u8ffd\u51fb\u80fd\u529b\u90fd\u4e0a\u4e00\u4e2a\u6863\u6b21\u3002\u4e4b\u540e\u9009\u62e9\u5362\u767b\u56de\u84dd\u4fdd\u8bc1\u6709\u6301\u7eed\u8f93\u51fa\u7684\u80fd\u529b\uff0c\u5927\u5e3d\u5b50\u548c\u6cd5\u7a7f\u68d2\u589e\u52a0\u5c0f\u4e11\u7684\u4f24\u5bb3\u3002<\/p>\n<h2>\u6280\u80fd\u9009\u62e9<\/h2>\n<p><img class=\"lazy\" data-original=\"https:\/\/si1.go2yd.com\/get-image\/0jCTBUl6B7Y\" style=\"display:block; margin-left:auto; margin-right:auto;\" \/><\/p>\n<p>\u6280\u80fd\u52a0\u70b9\u4e0a\uff0c\u9009\u62e9\u4e3bE\u526fW\u3002<\/p>\n<h2>\u82f1\u96c4\u73a9\u6cd5<\/h2>\n<p>1\u7ea7\u7684\u65f6\u5019\u70b9\u51faE\u6280\u80fd\uff0c\u5728\u7ebf\u4e0a\u591a\u7528E\u6280\u80fd\u6d88\u8017\u30023\u7ea7\u7684\u65f6\u5019\u5c31\u53ef\u4ee5\u52fe\u5f15\u5bf9\u65b9\u7684\u8d70\u4f4d\uff0c\u628a\u654c\u65b9\u5f15\u5230\u6709\u76d2\u5b50\u7684\u5730\u65b9\uff0c\u7136\u540e\u6050\u60e7\u6253\u51fa\u4e00\u5957\u6d88\u8017\u3002\u5982\u679c\u8fd9\u4e2a\u65f6\u5019\u5bf9\u9762\u4e0d\u56de\u5bb6\u9009\u62e9\u7ebf\u4e0a\u7ee7\u7eed\u5403\u7ebf\uff0c\u8fd9\u4e2a\u65f6\u5019\u5c31\u627e\u673a\u4f1aQ\u9690\u8eab\u5728\u4ed6\u8eab\u540e\u653e\u76d2\u5b50\uff0c\u7136\u540e\u76f4\u63a5\u51b2\u4e0a\u53bb\u51fb\u6740\u3002<\/p>\n<p><img class=\"lazy\" data-original=\"https:\/\/si1.go2yd.com\/get-image\/0jCTE9rxyAC\" style=\"display:block; margin-left:auto; margin-right:auto;\" \/><\/p>\n<p>\u56e2\u6218\u7684\u65f6\u5019\uff0c\u53ef\u4ee5\u591a\u5229\u7528\u76d2\u5b50\u7684\u6446\u653e\u4f4d\u7f6e\u8fdb\u884c\u56e2\u6218\u3002\u6216\u8005\u53ef\u4ee5\u7ed5\u540e\u5207C\u4f4d\uff0c\u7136\u540e\u91cc\u7528Q\u6280\u80fd\u7684\u9690\u8eab\u9003\u8d70\u3002<\/p>\n<p><img class=\"lazy\" data-original=\"https:\/\/si1.go2yd.com\/get-image\/0jCTEACNads\" style=\"display:block; margin-left:auto; margin-right:auto;\" \/><\/p>\n<p>AP\u4e0a\u5355\u5c0f\u4e11\u8fd8\u662f\u4ee5\u5355\u5e26\u4e3a\u4e3b\uff0c\u4e00\u822c\u4eba\u6765\u6293\u81f3\u5c11\u4e24\u4eba\u4ee5\u4e0a\u624d\u80fd\u6293\u6b7b\u3002<\/p>\n<h2>\u603b\u7ed3<\/h2>\n<p><img class=\"lazy\" data-original=\"https:\/\/si1.go2yd.com\/get-image\/0jCTBUqAz2W\" style=\"display:block; margin-left:auto; margin-right:auto;\" \/><\/p>\n<p>\u8fd9\u4e2a\u82f1\u96c4\u7684\u73a9\u6cd5\u8fc7\u4e8e\u6bd2\u7624\uff0c\u73a9\u5bb6\u4eec\u53ef\u4ee5\u7528\u8fd9\u5957\u73a9\u6cd5\u53bb\u4e0a\u6ce2\u5206\uff0c\u5404\u4f4d\u5c0f\u4f19\u4f34\u4eec\u8d76\u7d27\u884c\u52a8\u8d77\u6765\u5427\u3002<\/p><span style=\"font-size:16px;font-family:Microsoft YaHei;color:#E53333;text-indent:2em\"><\/span> <\/div>\n",
                "created_at": null,
                "updated_at": null,
                "unix": "1597492860"
            }
        ],
        "first_page_url": "http:\/\/127.0.0.1:8000\/Information?page=1",
        "from": 1,
        "last_page": 47,
        "last_page_url": "http:\/\/127.0.0.1:8000\/Information?page=47",
        "next_page_url": "http:\/\/127.0.0.1:8000\/Information?page=2",
        "path": "http:\/\/127.0.0.1:8000\/Information",
        "per_page": 10,
        "prev_page_url": null,
        "to": 10,
        "total": 469
    }


- 右边栏正在进行比赛 ( http://45.157.91.155/SidebarIng )


    [
        {
            "game": "https:\/\/500bf.com\/static\/index\/img\/lol_sel_icon.png",
            "team1": "OMD",
            "team1winnum": 0,
            "team2winnum": 0,
            "team2": "LNG.A",
            "events": "2020 LDL\u590f\u5b63\u8d5b",
            "time": "13:00"
        },
        ... ...
        {
            "game": "https:\/\/500bf.com\/static\/index\/img\/lol_sel_icon.png",
            "team1": "87",
            "team1winnum": 0,
            "team2winnum": 0,
            "team2": "WE.A",
            "events": "2020 LDL\u590f\u5b63\u8d5b",
            "time": "15:00"
        }
    ]

- 右边栏即将开始比赛 ( http://45.157.91.155/SidebarSonn )


    [
        {
            "gameimg": "https:\/\/www.500bf.com\/static\/index\/img\/lol_sel_icon.png",
            "team1": "OZ",
            "team2": "ELM",
            "time": "16:00"
        },
        ... ...
        {
            "gameimg": "https:\/\/www.500bf.com\/static\/index\/img\/csgo_sel_icon.png",
            "team1": "",
            "team2": "",
            "time": "21:00"
        }
    ]

 - 内容與 ( http://45.157.91.155/GetInformationBody/$id )
 
 
    [
        {
            "id": 3423,
            "thumbnail": "http:\/\/45.157.91.154\/static\/information\/15974839862588.jpg",
            "title": "WE\u60e8\u8d25LGD\u65e0\u7f18S10\u8d44\u683c\u8d5b\uff01\u6469\u6839\u8ff7\u4e4b\u8868\u73b0\u906dCat\u5410\u69fd",
            "gametype": "\u82f1\u96c4\u8054\u76df",
            "gametypeid": 3,
            "time": "2020\u5e7408\u670815\u65e5 17:33",
            "body": "<div class=\"new_conts\">\n<section>\n<p>\u5317\u4eac\u65f6\u95f48\u670814\u65e5\uff0cLPL\u5b63\u540e\u8d5b\u53f3\u534a\u533a\u7b2c\u4e00\u8f6e\u5bf9\u51b3\u5728WE\u548cLGD\u4e4b\u95f4\u62c9\u5f00\u5e37\u5e55\u3002\u53cc\u65b9\u56e0\u4e3a\u79ef\u5206\u8fc7\u5c11\uff0c\u8c01\u8f93\u6389\u90fd\u4f1a\u65e0\u7f18S10\u8d44\u683c\u8d5b\u3002\u5728\u5927\u6218\u56db\u5c40\u4e4b\u540e\uff0cLGD\u6210\u529f\u4ee53:1\u7684\u5927\u6bd4\u5206\u62ff\u4e0b\u6700\u540e\u7684\u80dc\u5229\u3002\u4e0b\u9762\u6211\u4eec\u5c31\u6765\u56de\u987e\u4e00\u4e0b\u8fd9\u56db\u5c40\u6bd4\u8d5b\u5427~<\/p>\n<p><img class=\"lazy\" data-original=\"https:\/\/inews.gtimg.com\/newsapp_bt\/0\/12280104499\/641\" style=\"display:block; margin-left:auto; margin-right:auto;\" \/><\/p>\n<h3>\u7b2c\u4e00\u5c40<\/h3>\n<p><img class=\"lazy\" data-original=\"https:\/\/inews.gtimg.com\/newsapp_bt\/0\/12280104500\/641\" style=\"display:block; margin-left:auto; margin-right:auto;\" \/><\/p>\n<p>\u524d\u671f\u5c0f\u82b1\u751f\u7537\u67aa\u914d\u5408\u4e2d\u91ce\u5165\u4fb5WE\u84ddbuff\u91ce\u533a\uff0c\u6210\u529f\u51fb\u6740\u5965\u62c9\u592b\u62ff\u5230\u4e00\u8840\u3002<\/p>\n<p>\u5728\u7b2c\u4e8c\u6761\u5c0f\u9f99\u4e89\u593a\u4e0a\uff0cWE\u5148\u884c\u6293\u6b7bLGD\u8f85\u52a9\u5854\u59c6\uff0c\u4f46\u662f\u5c0f\u9f99\u88ab\u5c0f\u82b1\u751f\u7537\u67aa\u62ff\u5230\uff0c\u968f\u540eLGD\u706b\u529b\u5168\u5f00\uff0c\u6770\u65af\u7206\u70b8\u8f93\u51fa\u62ff\u5230\u53cc\u6740\uff0c\u51fb\u9000WE\u4f17\u4eba\u3002<\/p>\n<p>\u63a5\u7740LGD\u638c\u63a7\u8282\u594f\uff0c\u9891\u7e41\u6293\u4eba\u3001\u63a8\u5854\u3001\u62ff\u9f99\uff0c\u901a\u8fc7\u7a33\u5065\u7684\u8fd0\u8425\uff0c\u9010\u6e10\u8695\u98dfWE\u3002<\/p>\n<p>30\u5206\u949f\uff0cLGD\u6210\u529f\u62ff\u4e0b\u5927\u9f99\uff0c\u60b2\u4f24\u5965\u62c9\u592b\u62a2\u9f99\u672a\u679c\uff0c\u60e8\u906d\u51fb\u6740\u3002<\/p>\n<p>\u51ed\u501f\u7740\u5927\u9f99buff\uff0cLGD\u4e00\u4e3e\u767b\u4e0aWE\u9ad8\u5730\uff0c\u867d\u7136\u827e\u5e0c\u88abWE\u96c6\u706b\u51fb\u6740\uff0c\u4f46\u662fLGD\u5176\u4f59\u56db\u4eba\u56e2\u706dWE\uff0c\u987a\u52bf\u4e00\u6ce2\u63a8\u6389\u4e3b\u5821\uff0c\u62ff\u4e0b\u7b2c\u4e00\u5c40\u6bd4\u8d5b\u80dc\u5229\uff01<\/p>\n<p><img class=\"lazy\" data-original=\"https:\/\/inews.gtimg.com\/newsapp_bt\/0\/12280104501\/641\" style=\"display:block; margin-left:auto; margin-right:auto;\" \/><\/p>\n<h3>\u7b2c\u4e8c\u5c40<\/h3>\n<p><img class=\"lazy\" data-original=\"https:\/\/inews.gtimg.com\/newsapp_bt\/0\/12280104503\/641\" style=\"display:block; margin-left:auto; margin-right:auto;\" \/><\/p>\n<p>\u524d\u671fWE\u4e2d\u91ce\u9891\u7e41\u8054\u52a8\uff0c\u5728\u91ce\u533a\u8d44\u6e90\u7684\u4e89\u593a\u4e0a\u5360\u636e\u4f18\u52bf\u3002<\/p>\n<p>10\u5206\u949f\u5de6\u53f3\uff0cWE\u7537\u67aagank\u4e0b\u8def\uff0c\u914d\u5408\u4e0b\u8def\u53cc\u4eba\u7ec4\u6210\u529f\u62ff\u4e0b\u827e\u5e0c\u4e00\u8840\u3002\u4e0d\u8fc7LGD\u62ff\u4e0b\u63a5\u4e0b\u6765\u7684\u4e00\u6761\u5c0f\u9f99\u3002<\/p>\n<p>\u63a5\u7740\u53cc\u65b9\u5e73\u7a33\u53d1\u80b2\u300217\u5206\u949f\uff0c\u53cc\u65b9\u5728\u5c0f\u9f99\u5904\u4ea4\u706b\uff0cLGD\u62ff\u4e0b\u542c\u724c\u9f99\uff0c\u867d\u7136\u585e\u62c9\u65af\u9635\u4ea1\uff0c\u4f46\u662f\u6210\u529f\u56e2\u706dWE\uff0c\u6253\u51fa\u4e0d\u9519\u7684\u4f18\u52bf\u3002<\/p>\n<p>23\u5206\u949f\uff0c\u53cc\u65b9\u53c8\u5f00\u59cb\u4e89\u593a\u5c0f\u9f99\u3002\u5c0f\u82b1\u751f\u5343\u73cf\u6ca1\u80fd\u62a2\u5230\u9f99\u9b42\uff0cWE\u6210\u529f\u62ff\u5230\u5c0f\u9f99\uff0c\u5e76\u51fb\u6740\u4e86\u5854\u59c6\uff0c\u8f6c\u5934\u60f3\u8981\u62ff\u4e0b\u5927\u9f99\u3002<\/p>\n<p>\u4e0d\u8fc7\u5728WE\u6253\u5927\u9f99\u65f6\uff0cLGD\u4f17\u4eba\u524d\u6765\u56f4\u527f\u3002\u516e\u591c\u585e\u62c9\u65af\u679c\u65ad\u51b2\u8fdb\u9f99\u5751\uff0c\u7206\u70b8\u8f93\u51fa\u62ff\u4e0b\u56db\u6740\uff0c\u914d\u5408\u961f\u53cb\u56e2\u706dWE\u3002<\/p>\n<p>\u968f\u540eLGD\u60f3\u8981\u62ff\u4e0b\u9f99\u9b42\uff0c\u4e0d\u6599\u88abWE\u7537\u67aa\u8d76\u6765\u62a2\u5230\u3002\u4f46\u662fLGD\u987a\u52bf\u53cd\u6253\uff0c\u76f4\u63a5\u56e2\u706dWE\u3002\u63a5\u7740\u4e00\u6ce2\u767b\u4e0a\u9ad8\u5730\uff0c\u62c6\u6389WE\u4e3b\u6c34\u6676\u3002LGD2:0WE\u62ff\u5230\u8d5b\u70b9\uff01<\/p>\n<p><img class=\"lazy\" data-original=\"https:\/\/inews.gtimg.com\/newsapp_bt\/0\/12280104504\/641\" style=\"display:block; margin-left:auto; margin-right:auto;\" \/><\/p>\n<h3>\u7b2c\u4e09\u5c40<\/h3>\n<p><img class=\"lazy\" data-original=\"https:\/\/inews.gtimg.com\/newsapp_bt\/0\/12280104505\/641\" style=\"display:block; margin-left:auto; margin-right:auto;\" \/><\/p>\n<p>\u5f00\u5c40\u5c0f\u82b1\u751f\u5343\u73cf\u76f4\u63a5\u6765\u4e2d\u8def\u6293\u9a6c\u8001\u5e08\uff0c\u903c\u51fa\u95ea\u73b0\u540e\u9669\u4e9b\u51fb\u6740\u3002<\/p>\n<p>\u4e0b\u8defLGD\u53cc\u4eba\u7ec4\u63a8\u7ebf\u8fc7\u6df1\uff0c\u60b2\u4f24\u7537\u67aa\u7ed5\u540egank\uff0c\u76f4\u63a5\u51fb\u6740\u7490\u7490\u62ff\u5230\u4e00\u8840\u3002<\/p>\n<p>\u968f\u540eWE\u4e0b\u8def\u53cc\u4eba\u7ec4\u518d\u5ea6\u6293\u5230\u8d70\u4f4d\u4e0d\u614e\u7684\u7490\u7490\uff0c\u5c06\u5176\u51fb\u6740\u3002<\/p>\n<p>9\u5206\u949f\u5de6\u53f3\uff0c\u53cc\u65b9\u5728\u5ce1\u8c37\u5148\u950b\u5904\u78b0\u649e\uff0cWE\u9cc4\u9c7c\u62ff\u4e0b\u5ce1\u8c37\u5148\u950b\uff0c\u4f46\u662fLGD\u5965\u6069\u5b8c\u7f8e\u8fdb\u573a\uff0c\u63a7\u5230\u591a\u4eba\uff0cLGD\u6253\u8d62\u56e2\u6218\u3002<\/p>\n<p>\u63a5\u7740\u5728\u5c0f\u9f99\u5904\u518d\u5ea6\u4ea4\u706b\uff0cWE\u62ff\u4e0b\u5c0f\u9f99\uff0cLGD\u827e\u5e0c\u5219\u662f\u51fb\u6740\u591a\u4eba\u3002<\/p>\n<p>17\u5206\u949f\uff0cWE\u6210\u529f\u62ff\u4e0b\u542c\u724c\u9f99\uff0c\u5728\u540e\u7eed\u7684\u56e2\u6218\u4e2d\uff0c\u9cc4\u9c7c\u6405\u4e71\u6218\u573a\uff0c\u6253\u51fa3\u636245\uff0cWE\u53d6\u5f97\u4f18\u52bf\u3002<\/p>\n<p>LGD\u901a\u8fc7\u4e0d\u65ad\u7684\u62c9\u626f\u548c\u627e\u673a\u4f1a\uff0c\u5c06\u5c40\u52bf\u9010\u6e10\u7a33\u4f4f\u3002\u6765\u523025\u5206\u949f\u540e\uff0cWE\u6d3e\u51fa\u7537\u67aasolo\u5c0f\u9f99\uff0cLGD\u5219\u662f\u60f3\u8981\u7528\u5927\u9f99\u505a\u4e92\u6362\u3002<\/p>\n<p>\u4e0d\u8fc7LGD\u65b9\u5927\u9f99\u8f83\u6162\uff0c\u88abWE\u8d76\u6765\u4f17\u4eba\u5305\u5939\uff0c\u867d\u7136\u62ff\u4e0b\u5927\u9f99\uff0c\u4f46\u662f\u4f17\u4eba\u90fd\u6b7b\u5728\u9f99\u5751\u3002WE\u987a\u52bf\u679c\u65ad\u4e00\u6ce2\u3002WE\u6273\u56de\u4e00\u5c40\uff0c\u53cc\u65b9\u6218\u62102:1\u3002<\/p>\n<p><img class=\"lazy\" data-original=\"https:\/\/inews.gtimg.com\/newsapp_bt\/0\/12280104506\/641\" style=\"display:block; margin-left:auto; margin-right:auto;\" \/><\/p>\n<h3>\u7b2c\u56db\u5c40<\/h3>\n<p><img class=\"lazy\" data-original=\"https:\/\/inews.gtimg.com\/newsapp_bt\/0\/12280104507\/641\" style=\"display:block; margin-left:auto; margin-right:auto;\" \/><\/p>\n<p>\u672c\u5c40\u6bd4\u8d5bLGD\u66f4\u6362\u8f85\u52a9\uff0cMark\u9009\u624b\u767b\u573a\u3002\u800c\u53cc\u65b9\u5728\u9009\u4eba\u65f6\uff0c\u53ea\u6709\u8f85\u52a9\u7490\u7490\u6362\u6210\u4e86\u62c9\u514b\u4e1d\u3002<\/p>\n<p>\u524d\u671f\u53cc\u65b9\u4e89\u593a\u4e0b\u8def\u6cb3\u87f9\u65f6\u53d1\u751f\u5927\u89c4\u6a21\u56e2\u6218\uff0cLGD\u652f\u63f4\u66f4\u5feb\uff0c\u6253\u51fa0\u63623\uff0c\u5c0f\u82b1\u751f\u5343\u73cf\u6210\u529f\u62ff\u4e0b\u53cc\u6740\u3002<\/p>\n<p>\u53cc\u65b9\u5b89\u7a33\u53d1\u80b2\u4e00\u6bb5\u65f6\u95f4\u540e\uff0c\u4e2d\u91ce\u53d1\u751f2V2\uff0c\u5343\u73cf\u4e0e\u6c99\u7687\u4e92\u6362\u3002<\/p>\n<p>\u5728\u7b2c\u4e8c\u6761\u5c0f\u9f99\u4e89\u593a\u4e0a\uff0cWE\u62ff\u4e0b\u5c0f\u9f99\uff0c\u4f46\u662fLGD\u75af\u72c2\u8ffd\u51fb\uff0c\u516e\u591c\u53d1\u6761\u95ea\u73b0\u62c9\u5230\u9cc4\u9c7c\uff0c\u5c06\u5176\u51fb\u6740\u3002<\/p>\n<p>\u968f\u540eLGD\u53d1\u51fa\u51f6\u731b\u7684\u653b\u52bf\uff0c\u63a5\u8fde\u6740\u4eba\uff0c\u5728\u4e2d\u8def\u63a8\u6389WE\u4e24\u5ea7\u9632\u5fa1\u5854\u3002<\/p>\n<p>22\u5206\u949f\u5de6\u53f3\uff0cWE\u7537\u67aa\u5728\u4e0a\u8def\u6293\u6b7b\u4e86\u516e\u591c\uff0c\u4f46\u662fLGD\u827e\u5e0c\u6210\u529f\u5927\u5230\u65e7\u68a6\uff0c\u540c\u6837\u5c06\u5176\u51fb\u6740\u3002<\/p>\n<p>LGD\u968f\u540e\u4e2d\u8def\u51b2\u4e0aWE\u9ad8\u5730\uff0c\u5c0f\u82b1\u751f\u5343\u73cf\u76f4\u63a5\u5355\u6740\u6389\u4e86\u9a6c\u8001\u5e08\u7684\u6c99\u7687\u3002\u63a5\u7740\u62c6\u6389\u4e86\u4e2d\u8def\u6c34\u6676\u3002<\/p>\n<p>25\u5206\u949fLGD\u5f00\u6253\u5927\u9f99\uff0cWE\u524d\u6765\u9a9a\u6270\uff0c\u88abLGD\u5168\u5458\u51fb\u6740\u3002\u968f\u540eLGD\u4e5f\u4e0d\u518d\u6253\u9f99\uff0c\u76f4\u63a5\u4e00\u6ce2\u63a8\u6389WE\u4e3b\u57fa\u5730\uff0c\u4ee53:1\u6210\u529f\u6218\u80dcWE\uff0c\u62ff\u4e0b\u6700\u540e\u7684\u80dc\u5229\uff01<\/p>\n<p><img class=\"lazy\" data-original=\"https:\/\/inews.gtimg.com\/newsapp_bt\/0\/12280104508\/641\" style=\"display:block; margin-left:auto; margin-right:auto;\" \/><\/p>\n<p>\u4eca\u5929\u7684\u56db\u5c40\u6bd4\u8d5b\uff0cLGD\u90fd\u53d1\u6325\u51fa\u8272\uff0c\u5728\u524d\u671f\u7ed9\u5230\u4e86WE\u4e0d\u5c0f\u7684\u538b\u529b\u3002\u4e2d\u8def\u516e\u591c\u9009\u624b\u9762\u5bf9\u8001\u4e1c\u5bb6WE\uff0c\u4e5f\u662f\u91cd\u62f3\u51fa\u51fb\uff0c\u4e1d\u6beb\u6ca1\u6709\u624b\u8f6f\u3002\u800cWE\u65b9\u4e0a\u5355Morgan\u53d1\u6325\u6b20\u4f73\uff0c\u89e3\u8bf4cat\u5728\u5fae\u535a\u4e2d\u5410\u69fd\uff1a<strong>\u201cmorgan\u674e\u5728\u8d63\u795e\u9b54\u201d<\/strong>~<\/p>\n<p><img class=\"lazy\" data-original=\"https:\/\/inews.gtimg.com\/newsapp_bt\/0\/12280104509\/641\" style=\"display:block; margin-left:auto; margin-right:auto;\" \/><\/p>\n<p>\u5728\u4e0b\u4e00\u8f6eWE\u5c06\u8981\u9762\u5bf9iG\uff0c\u5fc5\u987b\u8981\u8fde\u8d62\u4e24\u4e2aBO5\uff0cLGD\u624d\u4fdd\u5e95\u6709\u8d44\u683c\u6253\u5192\u6ce1\u8d5b\u3002\u540c\u5b66\u4eec\u89c9\u5f97LGD\u4eca\u5929\u7684\u53d1\u6325\u5982\u4f55\u5462\uff1f<\/p>\n<\/section> <\/div>\n",
            "created_at": null,
            "updated_at": null,
            "unix": "1597512780"
        }
    ]


### 登录注册功能

- 注册 post ( http://45.157.91.154/register?phone=18683346545&password=123456789&code=585320 )
    
        ['data' => '该手机号已被注册'], 422
        ['data' => '注册错误，请重试'], 500
        ['data' => '验证码错误'], 422
        ['data' => $token], 201

- 验证码接口 post ( http://45.157.91.154/code?phone=18683346545 )

        ['data' => '手机号已被注册'],422
        ['data' => -1], 422   *返回为负数时，表示验证码发送失败
        ['data' => 1],201
        
        短信发送后返回值	说　明
        -1	没有该用户账户
        -2	接口密钥不正确 [查看密钥]
        不是账户登陆密码
        -21	MD5接口密钥加密不正确
        -3	短信数量不足
        -11	该用户被禁用
        -14	短信内容出现非法字符
        -4	手机号格式不正确
        -41	手机号码为空
        -42	短信内容为空
        -51	短信签名格式不正确
        接口签名格式为：【签名内容】
        -52	短信签名太长
        建议签名10个字符以内
        -6	IP限制
        大于0	短信发送数量
        
- 登录 post ( http://45.157.91.154/code?phone=18683346545&password=123456789 )
    
        ['data' => $data], 201
        ['data' => '手机号或密码错误'], 422
