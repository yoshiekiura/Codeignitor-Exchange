var config = {
    'count_row_bids': 5,
    'count_row_ask': 5,
    'count_trade_history': 10,
    'keys_trade_history': ['date', 'buy/sell', 'gts', 'total units', 'total cost'],
    'count_order_open': 5,
    'keys_order_open': ['date', 'buy/sell', 'gts', 'total units', 'total cost', 'something'],
    'count_order_history': 5,
    'keys_order_history': ['date', 'buy/sell', 'gts', 'total units', 'total cost', 'something'],
    'rooms': [
        'GTS-NLG',
        'EUR-NLG'
    ]
};

module.exports = config;