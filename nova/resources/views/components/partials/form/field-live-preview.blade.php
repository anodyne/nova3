<div v-show="fieldType.baseHTML == 'text'">
	<input type="text" :class="attrClass" :placeholder="attrPlaceholder">
</div>
<div v-show="fieldType.baseHTML == 'textarea'">
	<textarea :class="attrClass" :placeholder="attrPlaceholder" :rows="attrRows"></textarea>
</div>
<div v-show="fieldType.baseHTML == 'radio'">
	<div v-for="option in options" class="radio">
		<input type="radio" value="option.value"> @{{ option.text }}
	</div>
</div>
<div v-show="fieldType.baseHTML == 'select'">
	<select :class="attrClass">
		<option v-for="option in options" :value="option.value">@{{ option.text }}</option>
	</select>
</div>
<div v-show="fieldType.baseHTML == 'search'">
	<input type="search" :class="attrClass" :placeholder="attrPlaceholder">
</div>
<div v-show="fieldType.baseHTML == 'email'">
	<input type="email" :class="attrClass" :placeholder="attrPlaceholder">
</div>
<div v-show="fieldType.baseHTML == 'url'">
	<input type="url" :class="attrClass" :placeholder="attrPlaceholder">
</div>
<div v-show="fieldType.baseHTML == 'tel'">
	<input type="tel" :class="attrClass" :placeholder="attrPlaceholder">
</div>
<div v-show="fieldType.baseHTML == 'number'">
	<input type="number" :min="attrMin" :max="attrMax" :step="attrStep" :value="attrValue" :class="attrClass" :placeholder="attrPlaceholder">
</div>
<div v-show="fieldType.baseHTML == 'range'">
	<input type="range" :min="attrMin" :max="attrMax" :value="attrValue" :placeholder="attrPlaceholder">
</div>
<div v-show="fieldType.baseHTML == 'date'">
	<input type="date" :min="attrMin" :max="attrMax" :class="attrClass" :placeholder="attrPlaceholder">
</div>
<div v-show="fieldType.baseHTML == 'month'">
	<input type="month" :class="attrClass" :placeholder="attrPlaceholder">
</div>
<div v-show="fieldType.baseHTML == 'week'">
	<input type="week" :class="attrClass" :placeholder="attrPlaceholder">
</div>
<div v-show="fieldType.baseHTML == 'time'">
	<input type="time" :class="attrClass" :placeholder="attrPlaceholder">
</div>
<div v-show="fieldType.baseHTML == 'datetime'">
	<input type="datetime" :class="attrClass" :placeholder="attrPlaceholder">
</div>
<div v-show="fieldType.baseHTML == 'datetime-local'">
	<input type="datetime-local" :class="attrClass" :placeholder="attrPlaceholder">
</div>
<div v-show="fieldType.baseHTML == 'color'">
	<input type="color" :class="attrClass">
</div>